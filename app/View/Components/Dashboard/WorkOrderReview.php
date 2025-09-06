<?php

namespace App\View\Components\Dashboard;

use Closure;
use App\Models\WorkOrder;
use App\Models\WorkOrderV;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class WorkOrderReview extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
       
    //    $WorkOrderV= $WorkOrderV;
        // dd($WorkOrderV);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $WorkOrders=  WorkOrderV::selectRaw("count(*) as count , status")->whereIn('status',[1,2,3,4,5,6,9])->groupBy("status")->orderBy('status')->get();
        $allCount = $WorkOrders->sum('count');
        $WorkOrdersFinishedCount=  WorkOrderV::whereIn('status',[4,5])->count();
        $percentage = ($allCount)? (int)round(($WorkOrdersFinishedCount/  $allCount)*100) : 0;
        $emergencyWorkOrderCount = WorkOrder::where('is_emergency_mission',0)->where('work_orders_type_id',3)->whereNull('mission_number')->count();
        return view('components.dashboard.work-order-review',compact('WorkOrders','allCount','percentage','emergencyWorkOrderCount'));
    }
}
