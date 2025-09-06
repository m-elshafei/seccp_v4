<?php

namespace App\DataTables;

use App\Models\WorkOrder;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;

class WorkOrderDataTable extends AppDataTable
{
    // protected $printColumns = [
    //     // ['data' => 'index', 'title' => 'م'],
    //     ['data' => 'work_order_number','width'=>'15px', 'title' => 'رقم امر العمل'],
    //     ['data' => 'received_date', 'title' => 'تاريخ استلام أمر العمل'],
    //     ['data' => 'work_type.code', 'title' => 'نوع أمر العمل'],
    //     ['data' => 'district.name', 'title' => 'الحى'],
    //     ['data' => 'current_department.name', 'title' => 'الادارة الحالية'],
    //     ['data' => 'status_title.title', 'title' => 'الحالة'],

    // ];

    function __construct() {
        $this->dataTableName = 'work_orders';
        $this->actionViewBlade = 'work_orders.datatables_actions_general';
        // $this->orderByArray=[[9, 'asc'], [2, 'asc']];
        $this->orderByArray=[ [3, 'desc']];
        // $this->actionVisible=false;
    }
    // public function dataTable($query)
    // {
    //     $dataTable = parent::dataTable($query);
    //     $dataTable->editColumn('work_order_number', '{{$id}}--{{$work_order_number}}');

    //     return $dataTable;
    // }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrder $model)
    {
        // ->orderBy("status" ,'asc')->orderBy("created_at" ,'desc')
        //->orderBy("id" ,'desc')
        // return $model->newQuery()->orderBy("status" ,'asc')->orderBy("work_orders.created_at" ,'desc')->with(["district","workType","currentDepartment"]);
        return $model->where('is_emergency_mission',0)->with(["district","workType","currentDepartment","electricity_company_employees"]);
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
            'work_order_number' => new Column(['title' => __('models/workOrders.fields.work_order_number'), 'data' => 'work_order_number','width'=>"10%"]),
            'received_date' => new Column(['title' => __('models/workOrders.fields.received_date'), 'data' => 'received_date','width'=>"10%"]),
            'created_at' => new Column(['title' => __('models/workOrders.fields.created_at'), 'data' => 'created_at','width'=>"10%"]),
            'work_type_id' => new Column([
                'title' => __('models/workOrders.fields.work_type_name'),
                'data' => 'workType.code',
                'width'=>"5%",
                'orderable'      => true,
                'searchable'     => true,
                'printable'  =>false,
                "render"=> 'function () {
                    row=meta.settings.aoData[meta.row]._aData;
                    if(row.work_type){
                        return \'<a title="\'+row.work_type.full_name+\'" href="/workOrdersManagement/workTypes/\'+row.work_type.id+\'">\'+row.work_type.code+\'</a>\'
                    }else{
                        return \'\'
                    }
                  }'
            ]),
            // 'electricity_company_employee_id' => new Column([
            //     'title' => __('models/workOrders.fields.work_type_name'),
            //     'data' => 'ElectricityCompanyEmployees.code',
            //     'width'=>"5%",
            //     'orderable'      => false,
            //     'searchable'     => false,
            //     'printable'  =>false,
            //     "render"=> 'function () {
            //         row=meta.settings.aoData[meta.row]._aData;
            //         if(row.work_type){
            //             return \'<a title="\'+row.work_type.full_name+\'" href="/workOrdersManagement/workTypes/\'+row.work_type.id+\'">\'+row.work_type.code+\'</a>\'
            //         }else{
            //             return \'\'
            //         }
            //       }'
            // ]),
            'workTypeName' => new Column([
                'title' =>  __('models/workOrders.fields.work_type_name'),
                'data' => 'work_type.code',
                'width'=>"3%",
                'visible'     => false,
                'orderable'      => false,
                'searchable'     => false
            ]),
            'district_id' => new Column(['title' => __('models/workOrders.fields.district_name'), 'data' => 'district.name','width'=>"10%","defaultContent"=> '']),
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
                'width'=>"5%",
                'orderable'      => false,
                'searchable'     => false,
            ]),
            'drilling_status' => new Column([
                'title' => 'حالة تنفيذ اعمال الحفر',
                'data' => 'drilling_status',
                'width'=>"3%",
                'orderable'      => false,
                'searchable'     => false,
                'printable'  =>false,
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
                'printable'  =>false,
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
            'status' => new Column([
                'title' => __('models/workOrders.fields.status'),
                'data' => 'status',
                'render' => 'function() {
                                    var $status =' . $work_order_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ]),
            'status_title.title' => new Column([
                'title' => __('models/workOrders.fields.status'),
                'data' => 'status_title.title',
                'printable'     => true,
                'visible'     => false,
                'searchable'     => false,
                'orderable'     => false,
                "defaultContent"=> ''
            ]),
            // 'id' => new Column(['title' => __('models/workOrders.fields.id'), 'data' => 'status']),
            // 'reference_number' => Column::make('reference_number')
            //                                 ->title('reference_number')
            //                                 ->data('reference_number')
            //                                 ->searchable(true)
            //                                 ->orderable(true)
            //                                 ->footer('Id')
            //                                 ->className("text-center")
            //                                 ->editColumn('reference_number', '{{$id}}--{{$reference_number}}')
            //                                 ->exportable(true)
            //                                 ->printable(true),
            // 'customer_number' => new Column(['title' => __('models/workOrders.fields.customer_number'), 'data' => 'customer_number']),
            // 'customer_name' => new Column(['title' => __('models/workOrders.fields.customer_name'), 'data' => 'customer_name']),
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
