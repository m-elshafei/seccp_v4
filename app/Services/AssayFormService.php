<?php

namespace App\Services;

use App\Enums\AssayFormEnum;
use App\Models\AssayForm;
use App\Repositories\AssayFormRepository;


class AssayFormService
{
    private $assayFormRepository;

    public function __construct(AssayFormRepository $assayFormRepository)
    {
        $this->assayFormRepository = $assayFormRepository;
    }


    public function create($input)
    {
        $workOrders = $this->assayFormRepository->find($input['work_order_id']);
        $input['work_order_id'] = $this->resolveWorkOrderId($input);
        $input['work_type_id'] = $workOrders->work_type_id ?? 0;
        $input['status'] = AssayFormEnum::NEW_ASSAY;

        if ($this->ensureNoDuplicateAssayForm($input['work_order_id'])) {
            return null; // duplicate found
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
        return AssayForm::where('work_order_id', $workOrderId)->exists();
    }
}
