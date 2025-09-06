<?php

namespace App\DataTables;

use App\DataTables\AppDataTable;
use App\Models\WorkOrdersPermitV;
use Yajra\DataTables\Html\Column;

class WorkOrdersPermitDataTable extends AppDataTable
{


    function __construct()
    {
        $this->dataTableName = 'work_orders_permits';
        $this->actionViewBlade = 'work_orders_permits.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrdersPermit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrdersPermitV $model)
    {
        return $model->newQuery()->with(['workOrdersPermitType']);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $work_order_permit_status = json_encode(config("const.work_order_permit_status"));
        return [
            'index' => $this->getIndexCol(),
            'work_order_number' => new Column(['title' => __('models/workOrdersPermits.fields.work_order_id'), 'data' => 'work_order_number']),
            'permit_number' => new Column(['title' => __('models/workOrdersPermits.fields.permit_number'), 'data' => 'permit_number']),
            'work_orders_permit_type_id' => new Column([
                'title' => __('models/workOrdersPermits.fields.work_orders_permit_type_id'),
                'data' => 'work_orders_permit_type.name',
                'name' => 'workOrdersPermitType.name',

                // 'data' => 'function (row,type,set){
                //     if ( type === "display" ) {
                //         console.log(row)
                //         // return row.work_orders_permit_type.name;
                //     }
                // }'
            ]),
            'sadad_number' => new Column(['title' => __('models/workOrdersPermits.fields.sadad_number'), 'data' => 'sadad_number']),
            'issued_amount' => new Column(['title' => __('models/workOrdersPermits.fields.issued_amount'), 'data' => 'issued_amount']),
            'length_total' => new Column(['title' => 'اجمالي الطول', 'data' => 'length_total']),
            'issue_date' => new Column([
                'title' => __('models/workOrdersPermits.fields.issue_date'),
                'data' => 'issue_date',
            ]),
            'period' => new Column([
                'title' => __('models/workOrdersPermits.fields.period'),
                'data' => 'period'
            ]),

            'total_permit_period' => new Column(['title' => __('models/workOrders.fields.total_work_period'), 'data' => 'total_work_period', 'searchable' => false, 'orderable' => false]),
            // 'total_permit_period_percentage' => new Column([
            //     'title' => 'المدة المنقضيه من التصريح',
            //     'data' => 'total_permit_period_percentage',
            //     'searchable' => false,
            //     'render' => 'function() {
            //     console.log(data);
            //     if(data <= 100){
            //                          var $status =' . $work_order_permit_status   . ';
            //                         // if (typeof $status[data] === "undefined") {
            //                         // return data;
            //                         // }
            //                         // return ( \'<span class="badge rounded-pill badge-light-primary">\' + data + \'</span>\'  );
            //                         var progress = 100;
            //                         return (\'<div class="d-flex flex-column"><small class="mb-1">\' + data +
            //                             \'%</small><div class="progress w-100 me-3" style="height: 6px;">\' +
            //                             \'<div class="progress-bar badge-light-primary" style="width: \'+data+\'%" aria-valuenow="\'+data+\'%" aria-valuemin="0" aria-valuemax="100"></div>\' +
            //                             \'</div>\' +
            //                             \'</div>\'
            //                           );
            // }else{
            //                         return ( \'<span class="badge badge-light-danger \' + data + \'">\' + منتهي+ \'</span>\'  );

            // }
            //                     }'
            // ]),

            'total_permit_period_percentage' => new Column([
                'title' => 'المدة المنقضيه من التصريح',
                'data' => 'total_permit_period_percentage',
                'orderable' => false,
                'searchable' => false,
                'render' => 'function() {
                    if (data <= 100) {
                        var progress = 100;
                        return (\'<div class="d-flex flex-column"><small class="mb-1">\' + data +
                            \'%</small><div class="progress w-100 me-3" style="height: 6px;">\' +
                            \'<div class="progress-bar badge-light-primary" style="width: \' + data + \'%" aria-valuenow="\' + data + \'%" aria-valuemin="0" aria-valuemax="100"></div>\' +
                            \'</div></div>\'
                        );
                    } else {
                        return (\'<span class="badge badge-light-danger">منتهي</span>\');
                    }
                }'
            ]),
            'total_permit_period_day' => new Column([
                'title' => 'المدة المتبقيه من التصريح',
                'data' => 'total_permit_period_day',
                'render' => 'function() {
                console.log(data);
                                if (typeof data === "undefined") {
                                    return "";
                                }else if (data <= 15){
                                    return (\'<span class="badge badge-light-danger">\' + data + \'</span>\');
                                }else {
                                    return data;
                            }
                        }',
                'searchable' => true,
                'orderable' => true,
            ]),

            'status' => new Column([
                'title' => __('models/workOrdersPermits.fields.status'),
                'data' => 'status',
                'render' => 'function() {
                                    var $status =' . $work_order_permit_status   . ';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ]),
            'status_title.title' => new Column([
                'title' => __('models/workOrdersPermits.fields.status'),
                'data' => 'status_title.title',
                'printable'     => true,
                'visible'     => false,
                'searchable'     => false,
                'orderable'     => false,
                "defaultContent" => ''
            ])
        ];
    }
}
