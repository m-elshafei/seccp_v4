<?php

namespace App\Repositories;

use App\Enums\AssayFormEnum;
use App\Models\WorkOrder;
use Illuminate\Database\Eloquent\Collection;

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


     public function getWorkOrdersForAssignment()
    {
        return WorkOrder::whereIn('status', [2, 3, 4, 5])
                        ->whereNull('mission_number')
                        ->get()
                        ->pluck('work_dispaly_number_permit', 'id');
    }


     public function getMissionWorkOrders()
    {
        return WorkOrder::whereNotNull('mission_number')
                        ->get()
                        ->pluck('work_dispaly_number_permit', 'id');
    }

      public function updateAssayFormsStatus(WorkOrder $workOrder, int $status)
    {
        $workOrder->assay_forms_status = $status;
        $workOrder->save();
        return $workOrder;
    }


    
    
}
