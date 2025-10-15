<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\WorkOrderService;
use Illuminate\Support\Collection;

class ItemRepository
{
    public $workOrderService;
    public $item;
    public function __construct(WorkOrderService $workOrderService, Item $item)
    {
        $this->workOrderService = $workOrderService;
        $this->item = $item;
    }
    public function getAllItemsGrouped()
    {
        return $this->item::with('category')->get();
    }

    /**
     * Get all WorkOrderServices grouped by category for a dropdown.
     *
     * @return Collection
     */
    public function getAllServicesGrouped()
    {
        return $this->workOrderService::with('servicesCategory')->get();
    }
}