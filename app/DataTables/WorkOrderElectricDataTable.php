<?php

namespace App\DataTables;

use App\Models\WorkOrder;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrderElectricDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_electrical';
        $this->actionViewBlade = 'work_orders.datatables_actions';
        $this->reportZoom = '78%';
        // $this->actionVisible=false;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrder $model)
    {
        return $model->getElectricWorkOrders()->with(["district","workType","currentDepartment","electrical_operation"]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $work_order_status= json_encode(config("const.work_order_general_status"));
        $work_order_drilling_status= json_encode(config("const.work_order_drilling_status"));
        $work_order_electricity_status = json_encode(config("const.work_order_electricity_status"));
        

        return [
            'index'=> $this->getIndexCol(),
            'work_order_number' => new Column(['title' => __('models/workOrders.fields.work_order_number'), 'data' => 'work_order_number','width' => "4%"]),
            // 'reference_number' => new Column(['title' => __('models/workOrders.fields.reference_number'), 'data' => 'reference_number']),
            'received_date' => new Column([
                'title' => __('models/workOrders.fields.received_date'), 
                'data' => 'received_date',
                'width' => "8%"
            ]),
            'work_type_id' => new Column([
                'title' => __('models/workOrders.fields.work_type_name'), 
                'data' => 'work_type.full_name',
                'width'=>"5%",
                'orderable'      => false,
                'searchable'     => false,//return '<a href="'+data+'">Download</a>';( data, type, row, meta )
                'printable'  =>false,
                "render"=> 'function () {
                    //console.log(meta.data);
                    row=meta.settings.aoData[meta.row]._aData;
                    return \'<a title="\'+data+\'" href="/workOrdersManagement/workTypes/\'+row.work_type.id+\'">\'+row.work_type.code+\'</a>\'
                  }'
            ]),
            'workTypeName' => new Column([
                'title' =>  __('models/workOrders.fields.work_type_name'),  
                'data' => 'work_type.code',
                'width'=>"3%",
                'visible'     => false,
                'orderable'      => false,
                'searchable'     => false
            ]),
            'district_id' => new Column(['title' => __('models/workOrders.fields.district_name'), 'data' => 'district.name','width' => "5%"]),
            // 'customer_number' => new Column(['title' => __('models/workOrders.fields.customer_number'), 'data' => 'customer_number']),
            // 'customer_name' => new Column(['title' => __('models/workOrders.fields.customer_name'), 'data' => 'customer_name']),
            'current_department_id' => new Column([
                'title' => __('models/workOrders.fields.current_department_name'), 
                'data' => 'current_department.name',
                'name' => 'currentDepartment.name',
                'orderable'      => false,
                'searchable'     => true,
                "defaultContent"=> '<span class="badge rounded-pill badge-light-danger">غير مربوط بادارة</span>'
            ]),
            'total_work_period' => new Column([
                'title' => __('models/workOrders.fields.total_work_period'), 
                'data' => 'total_work_period',
                'width'=>"1%",
                'orderable'      => false,
                'searchable'     => false,
            ]),
            // 'electrical_operation_status' => new Column([
            //     'title' => 'حالة التنفيذ',
            //     'data' => 'electrical_operation.status',
            //     'render' => 'function() {
            //                         if (typeof data === "undefined") {
            //                         return "-";
            //                         }
            //                         return data;
            //                     }'
            // ]),
            'drilling_status' => new Column([
                'title' => 'حالة تنفيذ اعمال الحفر',
                'data' => 'drilling_status',
                'width'=>"3%",
                'orderable'      => false,
                'searchable'     => false,
                'render' => 'function() {
                                if (typeof data === "undefined") {
                                return "-";
                                }
                                var $status =' . $work_order_drilling_status   .';
                                if (typeof $status[data] === "undefined") {
                                return data;
                                }
                                return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                            }'
            ]),
            'electrical_operations_status' => new Column([
                'title' => 'حالة تنفيذ اعمال الكهرباء',
                'data' => 'electrical_operations_status',
                'width'=>"3%",
                'orderable'      => false,
                'searchable'     => false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }
                                    var $status =' . $work_order_electricity_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ]),
            'electrical_complete_date' => new Column([
                'title' => 'تاريخ التنفيذ',
                'data' => 'electrical_operation.electrical_complete_date',
                'orderable'  => false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }
                                    return data;
                                }'
            ]),
            'electrical_worker_type' => new Column([
                'title' => 'نوع المنفذ',
                'data' => 'electrical_operation.electrical_worker_type',
                'orderable'  => false,
                'printable'  =>false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }else if(data === "employee"){
                                        return "موظف";
                                    }else{
                                        return "مقاول";
                                    }
                                    return data;
                                }'
            ]),
            'tablun' => new Column([
                'title' => 'الطبلون',
                'data' => 'electrical_operation.tablun',
                'orderable'  => false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }
                                    return data;
                                }'
            ]),
            'end' => new Column([
                'title' => 'رقم المخرج',
                'width'=>"3%",
                'data' => 'electrical_operation.end',
                'orderable'  => false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }
                                    return data;
                                }'
            ]),
            'end_type' => new Column([
                'title' => 'الجهد',
                'width'=>"3%",
                'data' => 'electrical_operation.end_type',
                'orderable'  => false,
                'render' => 'function() {
                                    if (typeof data === "undefined") {
                                    return "-";
                                    }
                                    return data;
                                }'
            ]),
            
            'status' => new Column([
                'title' => __('models/workOrders.fields.status'), 
                'data' => 'status',
                'width'=>"3%",
                'orderable'      => false,
                'searchable'     => false,
                'render' => 'function() {
                                    var $status =' . $work_order_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ])
            // 'branch_id' => new Column(['title' => __('models/workOrders.fields.branch_id'), 'data' => 'branch_id']),
            // 'city_id' => new Column(['title' => __('models/workOrders.fields.city_id'), 'data' => 'city_id']),
            
            //'x_axis' => new Column(['title' => __('models/workOrders.fields.x_axis'), 'data' => 'x_axis']),
            //'y_axis' => new Column(['title' => __('models/workOrders.fields.y_axis'), 'data' => 'y_axis']),
            //'street_name' => new Column(['title' => __('models/workOrders.fields.street_name'), 'data' => 'street_name']),
            
            //'electrical_station_number' => new Column(['title' => __('models/workOrders.fields.electrical_station_number'), 'data' => 'electrical_station_number']),
            //'electrical_stations_type_id' => new Column(['title' => __('models/workOrders.fields.electrical_stations_type_id'), 'data' => 'electrical_stations_type_id']),
            
           
            //'work_orders_stage_id' => new Column(['title' => __('models/workOrders.fields.work_orders_stage_id'), 'data' => 'work_orders_stage_id']),
            //'electricity_department_id' => new Column(['title' => __('models/workOrders.fields.electricity_department_id'), 'data' => 'electricity_department_id']),
            
            // 'needs_drilling_operations' => new Column(['title' => __('models/workOrders.fields.needs_drilling_operations'), 'data' => 'needs_drilling_operations']),
            // 'needs_electrical_work' => new Column(['title' => __('models/workOrders.fields.needs_electrical_work'), 'data' => 'needs_electrical_work']),
            // 'needs_work_orders_permit' => new Column(['title' => __('models/workOrders.fields.needs_work_orders_permit'), 'data' => 'needs_work_orders_permit']),
            // 'status' => new Column(['title' => __('models/workOrders.fields.status'), 'data' => 'status']),
            

            
            
            // if(data == 1){
            //     return "<span class=\'badge rounded-pill badge-light-primary me-1\'>جديد</span>"
            // }else if(data == 2){
            //     return "<span class=\'badge rounded-pill badge-light-primary me-1\'>جديد</span>"
            // }
            // return "لا";
            // var $status = {
            //     1: { title: "Current", class: "badge-light-primary" },
            //     2: { title: "Professional", class: " badge-light-success" },
            //     3: { title: "Rejected", class: " badge-light-danger" },
            //     4: { title: "Resigned", class: " badge-light-warning" },
            //     5: { title: "Applied", class: " badge-light-info' }
            //   };
            //   return (
            //     '<span class="badge rounded-pill " +
            //     $status[$status_number].class +
            //     '">' +
            //     $status[$status_number].title +
            //     '</span>'
            //   );
            
            // 'needs_program' => new Column(['title' => __('models/workOrders.fields.needs_program'), 'data' => 'needs_program']),
            //'finished_date' => new Column(['title' => __('models/workOrders.fields.finished_date'), 'data' => 'finished_date']),
            //'has_asbuilt' => new Column(['title' => __('models/workOrders.fields.has_asbuilt'), 'data' => 'has_asbuilt']),
            //'asbuilt_number' => new Column(['title' => __('models/workOrders.fields.asbuilt_number'), 'data' => 'asbuilt_number']),
            //'achievement_certificate_id' => new Column(['title' => __('models/workOrders.fields.achievement_certificate_id'), 'data' => 'achievement_certificate_id']),
            //'payment_clearance_id' => new Column(['title' => __('models/workOrders.fields.payment_clearance_id'), 'data' => 'payment_clearance_id']),
            //'work_orders_type_id' => new Column(['title' => __('models/workOrders.fields.work_orders_type_id'), 'data' => 'work_orders_type_id'])
        ];
    }

}
