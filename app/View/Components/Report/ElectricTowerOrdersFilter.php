<?php

namespace App\View\Components\Report;

use App\Enums\WorkOrderStatusEnum;
use App\Models\Consultant;
use App\Models\ElectricityDepartment;
use App\Models\WorkType;
use App\Services\WorkOrders\WorkOrderService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ElectricTowerOrdersFilter extends Component
{
    private $workOrderService;

    /**
     * Create a new component instance.
     */
    public function __construct(WorkOrderService $workOrderService)
    {
        $this->workOrderService = $workOrderService;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $electricityDepartments = $this->handleFilterListArray(ElectricityDepartment::pluck('name', 'id')->prepend('اختر', '')->toArray());
        $workOrdersType = WorkType::all()->map->only('id', 'full_name')->pluck('full_name', 'id')->prepend('اختر', '');
        $consultants = Consultant::pluck('name', 'name')->prepend('اختر', '');
        $myArray = WorkOrderStatusEnum::getOptions();
        $workOrderStatus = $this->workOrderService->getStausFromConfig('work_order_general_status', 'title', true);

        return view('components.report.electric-tower-orders-filter', compact(['workOrdersType', 'consultants', 'electricityDepartments', 'workOrderStatus']));
    }

    public function handleFilterListArray($myArray)
    {
        return $result = array_combine(
            array_map(function ($key, $value) {
                if ($value != 'اختر') {
                    return $key.'||'.$value;
                }
            }, array_keys($myArray), $myArray),
            array_values($myArray)
        );
    }
}
