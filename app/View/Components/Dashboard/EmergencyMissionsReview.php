<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\View\Component;
use App\Models\EmergencyMissionsV;
use Illuminate\Contracts\View\View;

class EmergencyMissionsReview extends Component
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
        $emergencyMissions=  EmergencyMissionsV::selectRaw("count(*) as count , status")->whereIn('status',[1,2,3,4,5,6,9])->groupBy("status")->orderBy('status')->get();
        // dd($emergencyMissions);
        $allCount = $emergencyMissions->sum('count');
        $emergencyMissionsFinishedCount=  EmergencyMissionsV::whereIn('status',[4,5])->count();
        $percentage = ($allCount)? (int)round(($emergencyMissionsFinishedCount/  $allCount)*100) : 0;
        //$emergencyWorkOrderCount = WorkOrder::where('is_emergency_mission',0)->where('work_orders_type_id',3)->whereNull('mission_number')->count();
        
        return view('components.dashboard.emergency-missions-review',compact('emergencyMissions','allCount','percentage'));
    }
}
