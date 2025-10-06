<?php

namespace App\Repositories;

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
}
