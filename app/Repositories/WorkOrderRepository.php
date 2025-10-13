<?php

namespace App\Repositories;

use App\Enums\AssayFormEnum;
use App\Models\WorkOrder;

class WorkOrderRepository
{

    private $model;

    public function __construct(WorkOrder $model)
    {
        $this->model = $model;
    }


    public function find($id)
    {
        return WorkOrder::find($id);
    }

    public function update(WorkOrder $workOrder, array $data)
    {
        $workOrder->fill($data);
        return $workOrder->save();
    }

    public function getApprovedWorkOrdersForDropdown()
    {
        return WorkOrder::whereHas('assay_forms', function ($query) {
            $query->where('status', AssayFormEnum::APPROVED_ASSAY);
        })->get()->pluck('work_dispaly_number_permit', 'id');
    }
}
