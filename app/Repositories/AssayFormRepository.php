<?php

namespace App\Repositories;

use App\Models\WorkOrder;
use App\Models\AssayForm;

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
}
