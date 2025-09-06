<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Carbon\Carbon;
use App\Models\WorkOrderV;
use Illuminate\Http\Request;
use App\Models\SystemComponent;
use App\Models\WorkOrderFollowV;
use App\Models\WorkOrdersPermitsFine;
use App\Http\Controllers\Reports\ReportController;



class TopManagementReportsController extends ReportController
{
    public $workOrder ;
    public $workOrderFollow ;
    public $workOrdersPermitsFine ;

    public function __construct(WorkOrderV $workOrder ,WorkOrderFollowV $WorkOrderFollow,WorkOrdersPermitsFine $workOrdersPermitsFine) {
        $this->workOrder = $workOrder;
        $this->workOrderFollow = $WorkOrderFollow;
        $this->workOrdersPermitsFine = $workOrdersPermitsFine;
    }

    public function allRecivedOrdersReport(Request $request)
    {

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


    public function permitFinesAmountsReport(Request $request)
    {
        $reportName = 'permitFinesAmountsReport';
        $workOrderFollow = $this->workOrdersPermitsFine
                ->getRestablishWorkOrders()
                ->filter('reports.'.$reportName.'.filter')
                ->get();
                $workOrderFollow->rowCount = $workOrderFollow->count() ;
                $workOrderFollow->landscapeLengthTotal = $workOrderFollow->map(function ($workOrder) {
                    return $workOrder->length_total;
                })->sum();
        $pdf = $this->getPDF($reportName,$workOrderFollow);
        return $this->handlePDF($request,$pdf);
    }


    public function totalPermitAmountsReport(Request $request)
    {

        $this->setSession('totalPermitAmountsReport','issue_date');
        $reportName = 'totalPermitAmountsReport';
        $workOrderFollow = $this->workOrderFollow

                ->getRestablishWorkOrders()
                ->filter('reports.'.$reportName.'.filter')
                ->with(["workOrders.district" , "workOrders.workType" , 'restablishWorkOrders'])
                ->get();
                $workOrderFollow->rowCount = $workOrderFollow->count() ;
                $workOrderFollow->landscapeLengthTotal = $workOrderFollow->map(function ($workOrder) {
                    return $workOrder->length_total;
                })->sum();
            $pdf = $this->getPDF($reportName,$workOrderFollow);
        return $this->handlePDF($request,$pdf);
    }





}
