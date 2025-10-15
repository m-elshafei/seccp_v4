<?php

namespace App\Services;

use App\Enums\AssayFormEnum;
use App\Models\AssayForm;
use App\Repositories\AssayFormRepository;
use App\Repositories\ItemRepository;
use App\Repositories\WorkOrderRepository;
use Carbon\Carbon;
use Exception;
use PDF;

class AssayFormService
{
    private $assayFormRepository;
    private $workOrderRepository;
    private $itemRepository;

    public function __construct(AssayFormRepository $assayFormRepository, WorkOrderRepository $workOrderRepository, ItemRepository $itemRepository)
    {
        $this->assayFormRepository = $assayFormRepository;
        $this->workOrderRepository = $workOrderRepository;
        $this->itemRepository = $itemRepository;
    }

    public function create($input)
    {
        $workOrders = $this->assayFormRepository->find($input['work_order_id']);
        $input['work_order_id'] = $this->resolveWorkOrderId($input);
        $input['work_type_id'] = $workOrders->work_type_id ?? 0;
        $input['status'] = AssayFormEnum::NEW_ASSAY;

        if ($this->ensureNoDuplicateAssayForm($input['work_order_id'])) {
            return null; 
        }

        $assayForm = $this->assayFormRepository->create($input);
        $workOrders->assay_forms_status = 1;
        $this->assayFormRepository->updateWorkOrders($workOrders);

        return $assayForm;
    }

    private function resolveWorkOrderId(array $data): int
    {
        return ($data['is_mission'] == 0)
            ? $data['work_order_id']
            : $data['mission_id'];
    }

    private function ensureNoDuplicateAssayForm(int $workOrderId): bool
    {
        return $this->assayFormRepository->checkAssayForm($workOrderId);
    }

         public function getCreateViewData(): array
    {
        $workOrders = $this->workOrderRepository->getWorkOrdersForAssignment();
        $missions = $this->workOrderRepository->getMissionWorkOrders();

        $workOrders->prepend('اختر', '');
        $missions->prepend('اختر', '');

        return [
            'workOrders' => $workOrders,
            'missions' => $missions,
        ];
    }

      public function getAssayFormById(int $id)
    {
        $assayForm = $this->assayFormRepository->find($id);

        return $assayForm;
    }


    protected function preparePrintData($assayForm): array
    {
        // Define static or configuration-based report parameters
        $report = [
            'font_name' => 'calibri',
            'font_size' => '18',
            'title_background_color' => '4CAF50',
        ];

        return [
            'data' => $assayForm,
            'dateTime' => Carbon::now()->format('h:i Y-m-d'),
            'report' => $report,
        ];
    }

    public function generateAssayPrintPdf(int $id)
    {
        $assayForm = $this->assayFormRepository->findForPrint($id);

        if (empty($assayForm)) {

            throw new Exception("AssayForm with ID $id not found for printing.");
        }

        $data = $this->preparePrintData($assayForm);

        $pdf = PDF::loadView('assay_forms.print_assay-2', $data);

        return $pdf;
    }


     protected function checkEditStatus($assayForm): void
    {
        if ($assayForm->status == AssayFormEnum::APPROVED_ASSAY) {
            throw new Exception('المقايسة تم اعتمادها من قبل');
        }

        if ($assayForm->status == AssayFormEnum::MOVED_ASSAY) {
            throw new Exception('المقايسة تم نقلها الي مشروع');
        }
    }


    public function getEditViewData(int $id): array
    {
        $assayForm = $this->assayFormRepository->find($id);

        if (empty($assayForm)) {
            throw new Exception("AssayForm with ID $id not found.");
        }

        $this->checkEditStatus($assayForm);

        $items = ['' => 'إختار من القائمة'];
        $this->itemRepository->getAllItemsGrouped()->map(function ($item) use (&$items) {
            $items[$item->category->name][$item->id] = $item->name.' - ['.$item->code.']';
        });

        $services = ['' => 'إختار من القائمة'];
        $this->itemRepository->getAllServicesGrouped()->map(function ($service) use (&$services) {
            $services[$service->servicesCategory->name][$service->id] = $service->name.' - ['.$service->code.']';
        });
        
        $assaysServices = $this->assayFormRepository->getAssayServicesByFormId($id);
        $assaysItems = $this->assayFormRepository->getAssayItemsByFormId($id);

        return [
            'assaysServices' => $assaysServices,
            'assaysItems' => $assaysItems,
            'assayForm' => $assayForm,
            'items' => $items,
            'services' => $services,
        ];
    }


    public function updateAssayForm(int $id, array $data): AssayForm
    {
        $assayForm = $this->assayFormRepository->find($id);

        if (empty($assayForm)) {

            throw new Exception("AssayForm with ID $id not found.");
        }


        return $this->assayFormRepository->update($assayForm, $data);
    }


        public function deleteAssayForm(int $id): bool
    {
        $assayForm = $this->assayFormRepository->find($id);

        if (empty($assayForm)) {
            throw new Exception("AssayForm with ID $id not found for deletion.");
        }
        
        $workOrder = $this->workOrderRepository->find($assayForm->work_order_id);
        
        if ($workOrder) {
            $this->workOrderRepository->updateAssayFormsStatus($workOrder, 0);
        }

        return $this->assayFormRepository->delete($assayForm);
    }


    public function approveAssayForm(int $id): AssayForm
    {
        $assayForm = $this->assayFormRepository->findForApproval($id);

        if (empty($assayForm)) {
            throw new Exception("AssayForm with ID $id not found.");
        }

        if ($assayForm->status != 1) {
            throw new Exception(__('The assay status should be new'));
        }

        if (!in_array($assayForm->workOrder->status, [4, 5])) {
            throw new Exception(__('The workOrder should be finished before approved the assay'));
        }

        if ($assayForm->workOrder->project_id !== null) {
            $workOrdersProject = $assayForm->workOrder->workOrdersProject;
            if ($workOrdersProject && $workOrdersProject->status != 2) {
                throw new Exception(__('You are not able to approve this assay because it is related to project'));
            }
        }

        $this->assayFormRepository->updateStatus($assayForm, AssayFormEnum::APPROVED_ASSAY);

        $this->workOrderRepository->updateAssayFormsStatus($assayForm->workOrder, AssayFormEnum::APPROVED_ASSAY);

        return $assayForm;
    }
}
