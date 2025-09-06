<?php

namespace App\Services\WorkOrders;

use App\Models\ElectricMeter;
use App\Models\ElectricalOperation;
use App\Services\WorkOrders\BaseWorkOrderService;


class ElectricWorkOrderService  extends BaseWorkOrderService
{

    public function  updateWorkOrder($request, $workOrder)
    {
        ElectricMeter::where('work_order_id', $workOrder->id)->delete();
        $total_electrical_counters = 0;
        $subscription_no = $request->get('subscription_no');

        if($request->get('meter_no')){
            $reading = $request->get('reading');
            $approved_capacity = $request->get('approved_capacity');
            $previous_capacity = $request->get('previous_capacity');
            foreach ($request->get('meter_no') as $i=>$meter_no){
                if (empty($meter_no) || empty($subscription_no[$i])){
                    continue;
                }
                ElectricMeter::create([
                    'work_order_id' => $workOrder->id,
                    'meter_no' => $meter_no,
                    'reading' => $reading[$i],
                    'subscription_no' => $subscription_no[$i],
                    'approved_capacity' => $approved_capacity[$i],
                    'previous_capacity' => $previous_capacity[$i],
                    'user_id' => auth()->id()
                ]);
                $total_electrical_counters++;
            }
        }
        

        $total_electrical_counters = $total_electrical_counters==0? $request->get('total_electrical_counters') : $total_electrical_counters;

        $operation = [
            'user_id' => auth()->id(),
            // 'status' => $request->get('electrical_operation_status'),
            'electrical_complete_date' => $request->get('electrical_complete_date'),
            'tablun' => $request->get('tablun'),
            'welding' => $request->get('welding'),
            'welding_type' => $request->get('welding_type'),
            'end' => $request->get('end'),
            'end_type' => $request->get('end_type'),
            'voltage' => $request->get('voltage'),
            'outlet_no' => $request->get('outlet_no'),
            'station_breaker' => $request->get('station_breaker'),
            'total_electrical_counters' => $total_electrical_counters,
            'electrical_worker_type' => $request->get('electrical_worker_type'),
            'electrical_employee_id' => $request->get('electrical_employee_id'),
            'electrical_contractor_id' => $request->get('electrical_contractor_id'),
        ];
        ElectricalOperation::updateOrCreate(['work_order_id' => $workOrder->id], $operation);

        // $workOrder = parent::updateWorkOrder($request, $workOrder);
        
        return $workOrder;
    }
    
}
