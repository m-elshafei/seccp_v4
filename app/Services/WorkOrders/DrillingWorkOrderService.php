<?php

namespace App\Services\WorkOrders;

use App\Models\WorkOrder;
use App\Models\LandscapeInformation;
use App\Services\WorkOrders\BaseWorkOrderService;


class DrillingWorkOrderService extends BaseWorkOrderService
{

    public function updateWorkOrder($request, $workOrder)
    {
        LandscapeInformation::updateOrCreate(['work_order_id' => $workOrder->id], $request->all());

        if ($request->project_id && !$workOrder->project_stage_id ){
            $count=WorkOrder::where('project_id',$request->project_id)->count();
            $request->merge([
                'project_stage_id' => $count+1
            ]);
        }
        
        // $workOrder = parent::updateWorkOrder($request, $workOrder);
        
        return $workOrder;
    }
    
}