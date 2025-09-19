<?php

namespace App\View\Components\Report\WorkOrders;

use App\Enums\WorkOrderStatusEnum;
use App\Models\Consultant;
use App\Models\Contractor;
use App\Models\ElectricityDepartment;
use App\Models\Employee;
use App\Models\WorkOrdersProject;
use App\Models\WorkType;
use App\Services\WorkOrders\WorkOrderService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WorkOrderFilter extends Component
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
        $consultants = $this->handleFilterListArray(Consultant::pluck('name', 'id')->prepend('اختر', '')->toArray());
        $workOrdersProject = $this->handleFilterListArray(WorkOrdersProject::pluck('name', 'id')->prepend('اختر', '')->toArray());
        $workTypes = WorkType::all()->pluck('full_name', 'id')->prepend('اختر', '')->toArray();
        $workTypes = $this->handleFilterListArray($workTypes);
        $drilling_worker = Contractor::pluck('company_name', 'company_name')->union(Employee::pluck('name', 'name'))->prepend('اختر', '')->toArray();
        $myArray = WorkOrderStatusEnum::getOptions();
        $workOrderStatus = $this->workOrderService->getStausFromConfig('work_order_general_status', 'title', true);

        return view('components.report.work-orders.work-order-filter', compact(['consultants', 'electricityDepartments', 'workOrderStatus', 'drilling_worker', 'workTypes', 'workOrdersProject']));
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
