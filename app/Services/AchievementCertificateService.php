<?php

namespace App\Services;

use App\Models\AchievementCertificate;
use App\Repositories\AchievementCertificateRepository;
use App\Repositories\AssayFormRepository;
use App\Repositories\WorkOrderRepository;
use Laracasts\Flash\Flash;

class AchievementCertificateService
{
    protected $workOrderRepository;

    public const NEW_COC = 'new'; 
    public const APPROVED_COC = 'approved'; 
    public const ERROR_NOT_FOUND = 'not_found';
    public const ERROR_CANNOT_EDIT = 'cannot_edit';
    public const ERROR_NO_ASSAY = 'no_assay_form';
    public const ERROR_DUPLICATE = 'duplicate_work_order';


    protected $certificateRepository;
    protected $assayFormRepository;


    public function __construct(
        WorkOrderRepository $workOrderRepository,
        AchievementCertificateRepository $certificateRepository,
        AssayFormRepository $assayFormRepository
    ) {
        $this->workOrderRepository = $workOrderRepository;
        $this->certificateRepository = $certificateRepository;
        $this->assayFormRepository = $assayFormRepository;
    }

    public function getWorkOrdersForCreationView()
    {
        $workOrders = $this->workOrderRepository->getApprovedWorkOrdersForDropdown();

        if ($workOrders->isEmpty()) {
            return null;
        }

        $workOrders->prepend('اختر', '');

        return $workOrders;
    }

    public function createCertificate(array $input): AchievementCertificate|string
    {
        $assayForm = $this->assayFormRepository->getApprovedFormByWorkOrderId($input['work_order_id']);

        if (empty($assayForm)) {
            return 'models/achievementCertificates.no work order available';
        }

        if ($this->certificateRepository->existsForWorkOrder($input['work_order_id'])) {
            return 'أمر العمل هذا له شهادة انجاز من قبل';
        }

        $data = $this->prepareCertificateData($input, $assayForm);

        return $this->certificateRepository->create($data);
    }


    protected function prepareCertificateData(array $input, $assayForm): array
    {
        $data = $input;
        $data['status'] = self::NEW_COC;
        $data['amount'] = $assayForm->amount;
        
        if (! isset($data['fines_amount']) || ! $data['fines_amount']) {
            $data['fines_amount'] = 0;
        }

        $data['net_amount'] = $this->calcNetAmount($data); 
        $data['final_amount'] = $data['net_amount'];
        
        return $data;
    }


    public function getShowViewData(int $id): ?array
    {
        $certificate = $this->certificateRepository->findWithWorkOrder($id);

        if (empty($certificate)) {
            return null;
        }

        $assayForm = $this->assayFormRepository->getApprovedFormByWorkOrderId(
            $certificate->work_order_id
        );

        $statusList = config('const.achievement_cert_status_list');
        $statusName = $statusList[$certificate->status] ?? 'Unknown';

        return [
            'achievementCertificate' => $certificate,
            'status' => $statusName,
            'assayForm' => $assayForm,
        ];
    }

    public function getEditViewData(int $id): array|string
    {
        $certificate = $this->certificateRepository->findWithWorkOrder($id);

        if (empty($certificate)) {
            return 'not_found';
        }

        if ($certificate->status == self::APPROVED_COC) {
             return 'cannot_edit';
        }

        $assayForm = $this->assayFormRepository->getApprovedFormByWorkOrderId(
            $certificate->work_order_id
        );

        return [
            'achievementCertificate' => $certificate,
            'assayForm' => $assayForm,
        ];
    }

    public function updateCertificate(int $id, array $input): AchievementCertificate|string
    {
        /** @var AchievementCertificate $certificate */
        $certificate = $this->certificateRepository->find($id);

        // 1. Initial Model Check
        if (empty($certificate)) {
            return self::ERROR_NOT_FOUND;
        }
        
        $assayForm = $this->assayFormRepository->getApprovedFormByWorkOrderId($input['work_order_id']);
        if (empty($assayForm)) {
            return self::ERROR_NO_ASSAY;
        }
        
        // 4. Duplicate Check (Work Order ID)
        if ($this->certificateRepository->checkDuplicateWorkOrder($input['work_order_id'], $id)) {
            return self::ERROR_DUPLICATE;
        }

        $dataToUpdate = $this->prepareCertificateUpdateData($input, $assayForm);

        // 6. Persistence
        $this->certificateRepository->update($certificate, $dataToUpdate);

        return $certificate;
    }

    protected function prepareCertificateUpdateData(array $input, $assayForm): array
    {
        $data = $input;

        $data['amount'] = $assayForm->amount;

        $data['net_amount'] = $this->calcNetAmount($data);
        
        if (!isset($data['final_amount']) || !$data['final_amount']) {
            $data['final_amount'] = $data['net_amount'];
        }

        return $data;
    }

    protected function calcNetAmount(array $data) 
    {
        return $data['amount'] - ($data['fines_amount'] ?? 0); 
    }


    public function deleteCertificate(int $id): bool|string
    {
        $certificate = $this->certificateRepository->find($id);

        if (empty($certificate)) {
            return self::ERROR_NOT_FOUND;
        }

        return $this->certificateRepository->delete($certificate);
    }

    public function handleUpdateError(string $errorCode)
    {
        switch ($errorCode) {
            case AchievementCertificateService::ERROR_NOT_FOUND:
                Flash::error(__('messages.not_found', ['model' => __('models/achievementCertificates.singular')]));
                return redirect(route('achievementCertificates.index'));
            
            case AchievementCertificateService::ERROR_CANNOT_EDIT:
                Flash::error(__('models/achievementCertificates.cannot change approved coc'));
                return redirect(route('achievementCertificates.index'));

            case AchievementCertificateService::ERROR_NO_ASSAY:
                Flash::error(__('models/achievementCertificates.no work order available'));
                return redirect()->back();

            case AchievementCertificateService::ERROR_DUPLICATE:
                return redirect()->back()->withErrors('أمر العمل هذا له شهادة انجاز من قبل')->withInput();
                
            default:
                Flash::error(__('messages.error_occurred'));
                return redirect()->back();
        }
    }
}