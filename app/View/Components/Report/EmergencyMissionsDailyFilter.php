<?php

namespace App\View\Components\Report;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\MissionType;
use App\Models\Employee;


class EmergencyMissionsDailyFilter extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $workOrdersType = MissionType::pluck('name', 'name')->prepend("اختر","");
        $Employee = Employee::pluck('name', 'name')->prepend("اختر","");

        return view('components.report.emergency-missions-daily-filter',compact('workOrdersType','Employee'));
    }
}
