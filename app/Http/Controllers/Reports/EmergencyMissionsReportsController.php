<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Carbon\Carbon;
use App\Models\EmergencyMissionsV;
use Illuminate\Http\Request;
use App\Models\SystemComponent;
use App\Http\Controllers\Reports\ReportController;



class EmergencyMissionsReportsController extends ReportController
{
    public $emergencyMission ;

    public function __construct(EmergencyMissionsV $emergencyMission) {
        $this->emergencyMission = $emergencyMission;
    }
    public function emergencyMissionsGeneralReport(Request $request)
    {
        $reportName = 'emergencyMissionsGeneralReport';
        $emergencyMissions = $this->emergencyMission
                        ->filter('reports.'.$reportName.'.filter')
                        ->withAggregate('workType','code')
                        ->withAggregate('currentDepartment','name')
                        ->withAggregate('assay_forms','id')
                        ->get();
                        $emergencyMissions->rowCount = $emergencyMissions->count() ;
                        $emergencyMissions->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                            return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                                ? $workOrder->landscape->length_total_before
                                : $workOrder->landscape->length_total;
                        })->sum();
        $pdf = $this->getPDF($reportName,$emergencyMissions);
        return $this->handlePDF($request,$pdf);
    }

    public function emergencyMissionsDailyReport(Request $request)
    {
        $this->setSession('emergencyMissionsDailyReport','received_date');

        $reportName = 'emergencyMissionsDailyReport';
        $emergencyMissions = $this->emergencyMission
                        ->getEmergencyMissions()
                        ->filter('reports.'.$reportName.'.filter')
                        ->withAggregate('currentDepartment','name')
                        ->withAggregate('district','name')
                        ->with("parent")
                        ->get();
                        // dd($emergencyMissions[0]);
                        $emergencyMissions->rowCount = $emergencyMissions->count() ;
                        $emergencyMissions->landscapeLengthTotal = $emergencyMissions->map(function ($workOrder) {
                            return $workOrder->total_cabel_length;
                        })->sum();
        $pdf = $this->getPDF($reportName,$emergencyMissions);
        return $this->handlePDF($request,$pdf);
    }


}
