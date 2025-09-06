<?php

namespace App\Services\WorkOrders;

use App\Models\ElectricityTower;
use App\Services\WorkOrders\BaseWorkOrderService;


class ElectricTowerWorkOrderService extends BaseWorkOrderService
{

    public function updateWorkOrder($request, $workOrder)
    {
        ElectricityTower::updateOrCreate(['work_order_id' => $workOrder->id], $request->all());
        
        // $workOrder = parent::updateWorkOrder($request, $workOrder);
        
        return $workOrder;
    }
    
}