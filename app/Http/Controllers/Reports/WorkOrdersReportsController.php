<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Carbon\Carbon;
use App\Models\WorkOrderV;
use Illuminate\Http\Request;
use App\Models\SystemComponent;
use App\Http\Controllers\Reports\ReportController;



class WorkOrdersReportsController extends ReportController
{
    public $workOrder ;

    public function __construct(WorkOrderV $workOrder) {
        $this->workOrder = $workOrder;
    }
    public function workOrdersGeneralReport(Request $request)
    {
        $reportName = 'workOrdersGeneralReport';
        $workOrders = $this->workOrder
                        ->filter('reports.'.$reportName.'.filter')
                        ->withAggregate('workType','code')
                        ->withAggregate('currentDepartment','name')
                        ->withAggregate('assay_forms','id')
                        ->get();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }

    function unfinishedDrillingWorkOrdersReport(Request $request) {

        $this->setSession('unfinishedDrillingWorkOrdersReport','received_date');
        $reportName = 'unfinishedDrillingWorkOrdersReport';
        $workOrders = $this->workOrder
                        ->getDrillingWorkOrders()
                        ->filter('reports.'.$reportName.'.filter')
                        ->withAggregate('workType','code')
                        ->withAggregate('currentDepartment','name')
                        ->withAggregate('assay_forms','id')
                        ->withAggregate('electricityDepartment','name')
                        ->withAggregate('consultant','name')
                        ->withAggregate('landscape','length_total')
                        ->get();
                        $workOrders->rowCount = $workOrders->count() ;
                        $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                            return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                                ? $workOrder->landscape->length_total_before
                                : $workOrder->landscape->length_total;
                        })->sum();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }

    function finishedDrillingWorkOrdersReport(Request $request) {
        //$input= session('reports.finishedDrillingWorkOrdersReport.filter');
        //$check = empty(array_filter($input, function ($a) { return $a !== null;}));
        //dd($check);

        $this->setSession('finishedDrillingWorkOrdersReport','received_date');
        $reportName = 'finishedDrillingWorkOrdersReport';
        $workOrders = $this->workOrder
                        ->getFinishedDrillingWorkOrders()
                        ->filter('reports.'.$reportName.'.filter')
                        ->withAggregate('workType','code')
                        ->withAggregate('currentDepartment','name')
                        ->withAggregate('assay_forms','id')
                        ->get();
                        $workOrders->rowCount = $workOrders->count() ;
                        $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                            return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                                ? $workOrder->landscape->length_total_before
                                : $workOrder->landscape->length_total;
                        })->sum();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
   }

   function electricTowerWorkOrdersReport(Request $request) {

        $this->setSession('electricTowerWorkOrdersReport','received_date');
        $reportName = 'electricTowerWorkOrdersReport';
        $workOrders = $this->workOrder
                    ->getElectricTowersWorkOrders()
                    ->filter('reports.'.$reportName.'.filter')
                    ->withAggregate('workType','code')
                    ->withAggregate('district','name')
                    ->withAggregate('currentDepartment','name')
                    // ->withAggregate('assay_forms','id')
                    // ->withAggregate('electricityDepartment','name')
                    ->withAggregate('consultant','name')
                    ->withAggregate('landscape','length_total')
                    ->with("electricity_tower")
                    ->get();
                    $workOrders->rowCount = $workOrders->count() ;
                    $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                        return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                            ? $workOrder->landscape->length_total_before
                            : $workOrder->landscape->length_total;
                    })->sum();
                    // $model->getElectricTowersWorkOrders()->with(["district","workType","currentDepartment", "electricity_tower"]);
        //    dd($workOrders);
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }

    function finishedElectricyWorkOrdersReport(Request $request) {
        $this->setSession('finishedElectricyWorkOrdersReport','received_date');
        $reportName = 'finishedElectricyWorkOrdersReport';
        $workOrders = $this->workOrder
                    ->getElectricWorkOrders()
                    ->filter('reports.'.$reportName.'.filter')
                    ->withAggregate('workType','code')
                    ->withAggregate('district','name')
                    ->withAggregate('currentDepartment','name')
                    ->withAggregate('consultant','name')
                    ->with("electrical_operation")
                    ->get();
                    $workOrders->rowCount = $workOrders->count() ;
                    $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                        return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                            ? $workOrder->landscape->length_total_before
                            : $workOrder->landscape->length_total;
                    })->sum();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }

    function electricyOperationsReport(Request $request) {

        $this->setSession('electricyOperationsReport','received_date');
        $reportName = 'electricyOperationsReport';
        $workOrders = $this->workOrder
                    ->getElectricWorkOrders()
                    ->filter('reports.'.$reportName.'.filter')
                    ->withAggregate('workType','code')
                    ->withAggregate('district','name')
                    ->withAggregate('currentDepartment','name')
                    ->withAggregate('consultant','name')
                    ->with("electrical_operation")
                    ->get();
                    $workOrders->rowCount = $workOrders->count() ;
                    $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                        return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                            ? $workOrder->landscape->length_total_before
                            : $workOrder->landscape->length_total;
                    })->sum();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }

    function electricyCountersReport(Request $request) {

        $this->setSession('electricyCountersReport','received_date');
        $reportName = 'electricyCountersReport';
        $workOrders = $this->workOrder
                    ->getElectricWorkOrders()
                    ->filter('reports.'.$reportName.'.filter')
                    ->withAggregate('workType','code')
                    ->withAggregate('district','name')
                    ->withAggregate('currentDepartment','name')
                    ->withAggregate('consultant','name')
                    ->with("electrical_operation")
                    ->get();
                    $workOrders->rowCount = $workOrders->count() ;
                    $workOrders->landscapeLengthTotal= collect($workOrders)->map(function ($workOrder) {
                        return (empty($workOrder->landscape->length_total) || $workOrder->landscape->length_total == 0)
                            ? $workOrder->landscape->length_total_before
                            : $workOrder->landscape->length_total;
                    })->sum();
        $pdf = $this->getPDF($reportName,$workOrders);
        return $this->handlePDF($request,$pdf);
    }
}
