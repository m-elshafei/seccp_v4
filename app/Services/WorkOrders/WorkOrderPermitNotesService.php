<?php

namespace App\Services\WorkOrders;

use App\Models\WorkOrderNote;
use App\Services\BaseService;


class WorkOrderPermitNotesService extends BaseService
{

    public function save($request, $workOrder)
    {
        if ($request->notes) {
            if($workOrder->work_order_number){
                $workOrderNote['permit_number'] = $workOrder->permit_number;
            }elseif($workOrder->mission_number){
                $workOrderNote['permit_number'] = $workOrder->permit_number;
            }else{
                $workOrderNote['work_order_number'] = '#';
            }
            $workOrderNote['work_order_id'] = $workOrder->id;
            $workOrderNote['note'] = $request->notes;
            if($workOrder->status){
                $workOrderNote['work_order_status'] = $workOrder->status;
            }else{
                $workOrderNote['work_order_status'] = 1;
            }
            $workOrderNote['user_id'] = auth()->id();
            $workOrder = WorkOrderNote::create($workOrderNote);
        }

    }

}
