<?php

namespace App\DataTables;

use App\Models\WorkOrderFollowV;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;

class WorkOrderDailyFollowDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_permits';
        $this->actionViewBlade = 'work_orders_permits.datatables_actions';
    }


    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                "dom"=> 'Bflrtip',//Bfrtip
                'stateSave' => false,
                'pageLength'=> 20,
                'lengthMenu'=> [5,10,15,20,30,50],
                'order'     => [[0, 'desc']],
                // "orderColumn" =>['id', '-id $1'],
                'drawCallback' => 'function() { feather.replace({width: 14,height: 14}); }',
                // 'initComplete' => 'function() {  }',
                'buttons'   => [
                    [
                       'extend' => 'print',
                       'className' => 'btn btn-primary btn-sm no-corner',
                       'text' => '<i data-feather="printer"></i> ' .__('auth.app.print').'',
                       'init'=> 'function(api, node, config) {$(node).removeClass("btn-secondary");$(node).removeClass("buttons-print");}'
                    ],
                    [
                       'extend' => 'reload',
                       'className' => 'btn btn-primary btn-sm no-corner',
                       'text' => '<i data-feather="refresh-cw"></i> ' .__('auth.app.reload').'',
                       'init'=> 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                    ],
                    [
                        'extend' => 'reset',
                        'className' => 'btn btn-primary btn-sm no-corner',
                        'text' => '<i data-feather="repeat"></i> ' .__('auth.app.reset').'',
                        'init'=> 'function(api, node, config) {$(node).removeClass("btn-secondary")}'
                     ],
                ],
                 'language' => [
                   'url' => url('//cdn.datatables.net/plug-ins/1.10.12/i18n/Arabic.json'),
                 ],
            ]);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrderFollowV $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrderFollowV $model)
    {
        return $model->getRestablishDailyWorkOrders()->with(["workOrders.district" , "workOrders.workType" , 'restablishWorkOrders'])->orderBy('created_at', 'desc');

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $work_order_status= json_encode(config("const.work_order_general_status"));
        $lab_result_status= json_encode(config("const.lab_result_status_list2"));
        $work_order_permit_status= json_encode(config("const.work_order_permit_status"));

        return [
            'index'=> $this->getIndexCol(),
            'work_order_number' => new Column([
                'title' => __('models/workOrders.fields.work_order_number'),
                'data' => 'work_order_number',
                'render' => 'function() {
                    row=meta.settings.aoData[meta.row]._aData;
                    if(data){

                        console.log(row);
                        return ( \'<a href=" \'+ `${BASE_URL}/workOrdersManagement/workOrders/${row.work_order_id}` + \'"> \' + data + \' </a>\'  );

                    }else{
                        if(row.is_emergency_mission){
                            return ( \'<a class="text-danger" title="مهمة طوارئ" href=" \'+ `${BASE_URL}/emergency/emergencyMissions/${row.work_order_id}` + \'"> \' + row.mission_number + \' </a>\'  );
                        }
                    return null;
                }}'
            ]),
            'work_permit_number' => new Column([
                'title' => __('models/workOrders.fields.work_permit_number'),
                'data' => 'permit_number',
                'render' => 'function() {
                    if(data){
                        row=meta.settings.aoData[meta.row]._aData;
                        return ( \'<a href=" \'+ `${BASE_URL}/workOrdersManagement/workOrdersPermits/${row.id}` + \'"> \' + data + \' </a>\'  );
                        return data;
                    }
                    return null;
                }'
            ]),

            //'received_date' => new Column(['title' => __('models/workOrders.fields.received_date'), 'data' => 'received_date']),
            'work_order_received_date' => new Column(['title' => __('models/workOrders.fields.received_date'), 'data' => 'work_order_received_date','width'=>"7%"]),
            'restablish_convert_date' => new Column(['title' => __('models/workOrders.fields.restablish_convert_date'), 'data' => 'restablish_convert_date','width'=>"7%"]),

            'work_type_code' => new Column([
                                            'title' => __('models/workOrders.fields.work_type_name'),
                                            'data' => 'work_type_code',
                                            'render' => 'function() {
                                                row=meta.settings.aoData[meta.row]._aData;
                                                if(data){
                                                    // console.log(data[0]);
                                                    if(row.work_type_id){
                                                        return ( \'<a href=" \'+ `${BASE_URL}/workOrdersManagement/workTypes/${row.work_type_id}` + \'"> \' + data + \' </a>\'  );
                                                    }
                                                    return data;
                                                }else{
                                                    if(row.is_emergency_mission){
                                                        return    ( \'<span class="text-danger">  مهمة طوارئ </span>\'  );
                                                    }
                                                }
                                                return null;
                                            }'
                                        ]),
            'district_name' => new Column(['title' => __('models/workOrders.fields.district_name'), 'data' => 'district_name']),
            // 'work_period' => new Column([
            //                                 'title' => __('models/workOrders.fields.work_period'),
            //                                 'data' => 'work_orders[0].total_work_period',
            //                                 'orderable'      => false,
            //                                 'searchable'     => false
            //                             ]),

            'layer_name' => new Column([
                'title' => __('models/workOrderFollows.fields.layer_name'),
                'data' => 'layer_name',
                'render' => 'function() {
                    if(data){
                        // console.log(data[0]);
                        var $status =' . $lab_result_status   .';
                        row=meta.settings.aoData[meta.row]._aData;
                        //return row.lab_result_status
                        if(data){
                           return ( \'<a class=" \' + $status[row.lab_result_status].class + \'" href=" \'+ `${BASE_URL}/restablishWorkOrders/workOrderFollows/${row.id}/edit` + \'"> \' + data + \' </a>\'  );
                            //return ( \'<span class="badge rounded-pill \' + $status[row.lab_result_status].class + \'"> \' + data + \' </span>\'  );
                        }
                        return data;
                    }
                    return null;
                }'
            ]),
            'layer_date' => new Column([
                'title' => __('models/workOrderFollows.fields.layer_date'),
                'data' => 'layer_date',
                'render' => 'function() {
                    if(data){
                        // console.log(data[0]);
                        var $status =' . $lab_result_status   .';
                        row=meta.settings.aoData[meta.row]._aData;
                        if(data){
                           //return ( \'<a href=" \'+ `${BASE_URL}/workOrdersManagement/workTypes/${row.work_type_id}` + \'"> \' + data + \' </a>\'  );
                            return ( \'<span class="badge rounded-pill \' + $status[row.lab_result_status].class + \'"> \' + data + \' </span>\'  );
                        }
                        return data;
                    }
                    return null;
                }'
            ]),
            // 'layer1' => new Column([
            //     'title' => 'ط1',
            //     'data' => 'work_orders',
            //    'render' => 'function() {
            //     //    console.log(data[0].layer1.start_date);
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer1)? data[0].layer1.lab_result_status:null ;
            //         var start_date = (data[0].layer1)? data[0].layer1.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            // 'layer2' => new Column([
            //     'title' => 'ط2',
            //     'data' => 'work_orders',
            //     'render' => 'function() {
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer2)? data[0].layer2.lab_result_status:null ;
            //         var start_date = (data[0].layer2)? data[0].layer2.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            // 'layer3' => new Column([
            //     'title' => 'ط3',
            //     'data' => 'work_orders',
            //     'render' => 'function() {
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer3)? data[0].layer3.lab_result_status:null ;
            //         var start_date = (data[0].layer3)? data[0].layer3.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            // 'layer4' => new Column([
            //     'title' => 'MC1',
            //     'data' => 'work_orders',
            //     'render' => 'function() {
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer4)? data[0].layer4.lab_result_status:null ;
            //         var start_date = (data[0].layer4)? data[0].layer4.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            // 'layer5' => new Column([
            //     'title' => 'اسفلت',
            //     'data' => 'work_orders',
            //     'render' => 'function() {
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer5)? data[0].layer5.lab_result_status:null ;
            //         var start_date = (data[0].layer5)? data[0].layer5.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            // 'layer6' => new Column([
            //     'title' => 'رصيف',
            //     'data' => 'work_orders',
            //     'render' => 'function() {
            //         var $status =' . $lab_result_status   .';
            //         var lab_result_status = (data[0].layer6)? data[0].layer6.lab_result_status:null ;
            //         var start_date = (data[0].layer6)? data[0].layer6.start_date:null ;

            //         if(lab_result_status){
            //             return ( \'<span class="badge rounded-pill \' + $status[lab_result_status].class + \'"> \' + start_date + \' </span>\'  );
            //         }
            //         return null;
            //     }'
            // ]),
            'total_permit_period' => new Column([
                'title' => __('models/workOrderFollows.fields.total_permit_period'),
                'data' => 'total_permit_period',
                'searchable' => false,
                'orderable' => false
            ]),
            'total_permit_period_percentage' => new Column([
                'title' => 'المدة المنقضيه من التصريح',
                'data' => 'total_permit_period_percentage',
                'searchable' => false,
                'orderable' => false,
                'render' => 'function() {
                        var progress = 100;
                        if (data >= 100) {
                            return `<span class="badge badge-light-danger">منتهي</span>`;
                        }else {
                            return `
                                    <div class="d-flex flex-column">
                                        <small class="mb-1">${data}%</small>
                                        <div class="progress w-100 me-3" style="height: 6px;">
                                        <div class="progress-bar badge-light-primary"
                                            style="width: ${data}%"
                                            aria-valuenow="${data}%"
                                            aria-valuemin="0"
                                            aria-valuemax="100">
                                        </div>
                                        </div>
                                    </div>`;
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
            'work_order_status' => new Column([
                'title' => 'حالة أمر العمل',
                'data' => 'work_order_status',
                'render' => 'function() {
                                    var $status =' . $work_order_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ]),
            'PermitStatus' => new Column([
                'title' => 'حالة التصريح',
                'data' => 'status',
                'render' => 'function() {
                                            var $status =' . $work_order_permit_status   .';
                                            if (typeof $status[data] === "undefined") {
                                            return data;
                                            }
                                            return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                        }'
            ]),
            'issued_amount' => new Column(['title' => __('models/workOrdersPermits.fields.issued_amount'), 'data' => 'issued_amount','width'=>"5%"]),
            'clearance_sdad_amount' => new Column(['title' => __('models/workOrdersPermits.fields.clearance_sdad_amount'), 'data' => 'clearance_sdad_amount','width'=>"5%"]),
            // 'total_amount' => new Column(['title' => __('models/workOrdersPermits.fields.total_amount'), 'data' => 'total_amount','width'=>"5%"]),
            'action' => new Column([
                'title' => __('action'),
                'data' => 'id',
                'render'=> 'function() {
                return \'<a href="/restablishWorkOrders/workOrderFollows/\' + data + \'/edit" class="btn btn-outline-warning btn-sm"><i data-feather="edit"></i></a>\';
                }'
            ])

        ];
    }

}
