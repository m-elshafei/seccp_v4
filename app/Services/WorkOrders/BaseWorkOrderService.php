<?php

namespace App\Services\WorkOrders;

use App\Models\Branch;
use App\Models\WorkType;
use App\Models\WorkOrder;
use App\Utils\SessionUtil;
use Laracasts\Flash\Flash;
use App\Services\BaseService;


class BaseWorkOrderService  extends BaseService
{
    public function createWorkOrder($request)
    {
        $input = $request->all();
        $branchId = SessionUtil::getCurrentBranch();
        $branchData=Branch::find($branchId);

        $city_id = $branchData->city_id;

        $input['branch_id']=$branchId;
        $input['city_id']=$city_id;

        if(isset($input['work_type_id']) && $input['work_type_id']){
            $workTypeData = WorkType::find($input['work_type_id']);
            $input['needs_drilling_operations'] = $workTypeData->needs_drilling_operations;
            $input['needs_electrical_work'] = $workTypeData->needs_electrical_work;
            $input['needs_work_orders_permit'] = $workTypeData->needs_work_orders_permit;
            $input['owner_department_id'] = $workTypeData->default_department_id;
            //$input['current_department_id'] = $workTypeData->default_department_id;
        }

        $workOrder = WorkOrder::create($input);
        return $workOrder;

    }

    public function updateWorkOrder($request, $workOrder)
    {
        $workOrder->fill($request->except("note"));
        $workOrder->save();
        return $workOrder;
    }

    public function getModeName($routeName="")
    {
        if($routeName == "workOrdersDrilling"){
            $mode ="drilling";
        }elseif($routeName == "workOrdersDrillingProjects"){
            $mode ="drillingProjects";
        }elseif($routeName == "workOrdersElectricity"){
            $mode ="electricity";
        }elseif($routeName == "workOrdersElectricTowers"){
            $mode ="electricTowers";
        }else{
            $mode ="general";
        }
        return $mode;
    }
}
