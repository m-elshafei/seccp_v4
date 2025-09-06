<?php

namespace App\Http\Controllers\Reports;

use PDF;
use Carbon\Carbon;
use App\Models\WorkOrderFollowV;
use Illuminate\Http\Request;
use App\Models\SystemComponent;
use App\Http\Controllers\Reports\ReportController;
use App\Models\WorkOrderFollow;

class PermitFollowReportsController extends ReportController
{
    public $workOrderFollow ;

    public function __construct(WorkOrderFollowV $WorkOrderFollow) {
        $this->workOrderFollow = $WorkOrderFollow;
    }


    public function workOrdersPermitReport(Request $request)
    {

        $this->setSession('workOrdersPermitReport','issue_date');
        $reportName = 'workOrdersPermitReport';

        $status = $request->session()->get('reports.workOrdersPermitReport.filter.status');

        $firstPart = strtok($status, '||');

        $query = $this->workOrderFollow
            ->getRestablishWorkOrders()
            ->filter('reports.' . $reportName . '.filter')
            ->with(['workOrders.district', 'workOrders.workType', 'restablishWorkOrders']);

        if ($firstPart == 0) {
            $workOrderFollow = $query->where('end_date', '<=', Carbon::now())->get();
        } else {
            $workOrderFollow = $query->where(function ($query) use ($firstPart) {
                if ($firstPart) {
                    $query->where('status', $firstPart); // Replace 'status_column_name' with the actual column name
                }
            })->get();
        }
        $workOrderFollow->rowCount = $workOrderFollow->count() ;
        $workOrderFollow->landscapeLengthTotal = $workOrderFollow->map(function ($workOrder) {
            return $workOrder->length_total;
        })->sum();

        $pdf = $this->getPDF($reportName, $workOrderFollow);

        return $this->handlePDF($request, $pdf);
    }


//     function unfinishedDrillingWorkOrdersReport(Request $request) {
//         $reportName = 'unfinishedDrillingWorkOrdersReport';
//         $workOrders = $this->workOrder
//                         ->getDrillingWorkOrders()
//                         ->filter('reports.'.$reportName.'.filter')
//                         ->withAggregate('workType','code')
//                         ->withAggregate('currentDepartment','name')
//                         ->withAggregate('assay_forms','id')
//                         ->withAggregate('electricityDepartment','name')
//                         ->withAggregate('consultant','name')
//                         ->withAggregate('landscape','length_total')
//                         ->get();
//         $pdf = $this->getPDF($reportName,$workOrders);
//         return $this->handlePDF($request,$pdf);
//     }

//     function finishedDrillingWorkOrdersReport(Request $request) {
//         $reportName = 'finishedDrillingWorkOrdersReport';
//         $workOrders = $this->workOrder
//                         ->getFinishedDrillingWorkOrders()
//                         ->filter('reports.'.$reportName.'.filter')
//                         ->withAggregate('workType','code')
//                         ->withAggregate('currentDepartment','name')
//                         ->withAggregate('assay_forms','id')
//                         ->get();

//         $pdf = $this->getPDF($reportName,$workOrders);
//         return $this->handlePDF($request,$pdf);
//    }


}
