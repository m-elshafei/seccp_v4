<?php

namespace App\Repositories;

use App\Models\WorkOrderService;

class WorkOrderServiceRepository
{
    public function find(int $id)
    {
        return WorkOrderService::find($id);
    }
}