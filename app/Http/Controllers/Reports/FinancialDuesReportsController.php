<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Carbon\Carbon;
use App\Models\WorkOrderV;
use Illuminate\Http\Request;
use App\Models\SystemComponent;
use App\Http\Controllers\Reports\ReportController;



class FinancialDuesReportsController extends ReportController
{
    public $workOrder ;

    public function __construct(WorkOrderV $workOrder) {
        $this->workOrder = $workOrder;
    }

    public function ordersWithOutCertificatesReport(Request $request)
    {
        $this->setSession('ordersWithOutCertificatesReport','received_date');
        $reportName = 'ordersWithOutCertificatesReport';
        $workOrders = $this->workOrder
                        ->filter('reports.'.$reportName.'.filter')
                        // ->getElectricTowersWorkOrders()
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


    public function ordersWithOutFinancialDuesReport(Request $request)
    {
        $this->setSession('ordersWithOutFinancialDuesReport','received_date');
        $reportName = 'ordersWithOutFinancialDuesReport';
        $workOrders = $this->workOrder
                        ->filter('reports.'.$reportName.'.filter')
                        // ->getElectricTowersWorkOrders()
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


    public function finishedFinancialDuesReport(Request $request)
    {

        $this->setSession('finishedFinancialDuesReport','received_date');
        $reportName = 'finishedFinancialDuesReport';
        $workOrders = $this->workOrder
                        ->filter('reports.'.$reportName.'.filter')
                        // ->getElectricTowersWorkOrders()
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


    public function allFinancialDuesReport(Request $request)
    {
        $this->setSession('allFinancialDuesReport','received_date');
        $reportName = 'allFinancialDuesReport';
        $workOrders = $this->workOrder
                        ->filter('reports.'.$reportName.'.filter')
                        // ->getElectricTowersWorkOrders()
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


}
