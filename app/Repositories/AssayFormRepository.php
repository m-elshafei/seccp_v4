<?php

namespace App\Repositories;

use App\Enums\AssayFormEnum;
use App\Models\AssayForm;
use App\Models\WorkOrder;

class AssayFormRepository
{
    public function find($input)
    {
        $workOrders = WorkOrder::find($input);

        return $workOrders;
    }

    public function create($input)
    {
        $assayForm = AssayForm::create($input);

        return $assayForm;
    }

    public function checkAssayForm($workOrderId)
    {
        $assayForm_count = AssayForm::where('work_order_id', $workOrderId)->count();

        return $assayForm_count;
    }

    public function updateAssayForm($input)
    {
        $assayForm = AssayForm::create($input);

        return $assayForm;
    }

    public function updateWorkOrders($workOrders)
    {
        $workOrders->save();

        return $workOrders;
    }

    public function getApprovedFormByWorkOrderId(int $workOrderId): ?AssayForm
    {
        return AssayForm::where([
            'work_order_id' => $workOrderId,
            'status' => AssayFormEnum::APPROVED_ASSAY,
        ])->first();
    }

 

}
