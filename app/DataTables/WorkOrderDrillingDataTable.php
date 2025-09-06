<?php

namespace App\DataTables;

use App\Models\WorkOrderV as WorkOrder;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrderDrillingDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_drilling';
        $this->actionViewBlade = 'work_orders.datatables_actions';
        $this->orderByArray=[ [3, 'asc']];
        $this->reportZoom = '87%';
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
        return $model->getDrillingWorkOrders()->with(["district","workType","landscape","electricityDepartment","consultant"]);//->orderBy('last_action_date_time')
        // return $model->newQuery()->where("status","<>",1)->where("current_department_id",1)->with(["district","workType","landscape"]);
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
        $work_order_permit_status= json_encode(config("const.work_order_permit_status"));
        return [
            'index'=> $this->getIndexCol(),
            'work_order_number' => new Column([
                'title' => __('models/workOrders.fields.work_order_number'),
                'data' => 'work_order_number',
                'orderable'     => true,
                'width'=>"10%",
                'render' => 'function () {
                                row=meta.settings.aoData[meta.row]._aData;
                                var description = row.description?.trim();
                                if((row.description?.trim()?.length || 0) === 0){
                                    description = "لا يوحد وصف العمل";
                                }
                                return `
                                    <span data-toggle="tooltip" title="${description}">
                                        <a href="/workOrdersManagement/workOrders/${row.id}" class="text-info">
                                            <i data-feather="info"></i> ${data}
                                        </a>
                                    </span>
                                `;
                }'
            ]),
            'received_date' => new Column([
                'title' => __('models/workOrders.fields.work_order_date'),
                'data' => 'received_date',
                'width'=>"15%",
            ]),
            'last_action_date_time' => new Column([
                'title' => __('models/lastAction.fields.name'),
                'data' => "last_action_date_time",
                'orderable'     => true,
                'defaultContent'=> '',
            ]),
            'workType.code' => new Column([
                'title' => __('models/workOrders.fields.work_type_name'),
                'data' => 'workType.code',
                'width'=>"5%",
                'orderable'     => true,
                'searchable'     => true,
                'printable'  =>false,
                // 'order_data' => 'workType.code',
                // 'order_data_type'=>'dom-text',
                "render"=> 'function () {
                    row=meta.settings.aoData[meta.row]._aData;
                    console.log(row);
                    return \'<a title="\'+row.work_type.full_name+\'" href="/workOrdersManagement/workTypes/\'+row.work_type.full_name+\'">\'+row.work_type.code+\'</a>\'
                  }',
            ]),
            'workTypeName' => new Column([
                'title' =>  __('models/workOrders.fields.work_type_name'),
                'data' => 'work_type.code',
                'width'=>"3%",
                'visible'     => false,
                'orderable'     => true,
                'searchable'     => false
            ]),
            'district_id' => new Column([
                'title' => __('models/workOrders.fields.district_name'),
                'data' => 'district.name',
                'width'=>"10%",
            ]),
            'total_work_period' => new Column([
                'title' => __('models/workOrders.fields.total_work_period'),
                'data' => 'total_work_period',
                'orderable'     => false,
                'searchable'     => false,
                'width'=>"3%",
            ]),

            'electricity_department_name' => new Column([
                'title' => __('models/workOrders.fields.electricity_department_name'),
                'data' => 'electricity_department.name',
                'orderable'     => false,
                'width'=>"7%",
                'defaultContent'=> '',
                'searchable'     => false,
            ]),
            // 'length_total' => new Column([
            //     'title' => __('models/workOrders.fields.length_total_short'),
            //     // 'data' => ('landscape.length_total' === null || 'landscape.length_total' === 0) ? 'landscape.length_total_before':'length_total',
            //     'data' => "landscape.length_total_before",
            //     'orderable'      => false,
            //     'width'=>"3%",
            //     'defaultContent'=> ''
            // ]),
            'calc_length_total' => new Column([
                'title' => __('models/workOrders.fields.length_total_short'),
                'data' => 'calc_length_total',
                'orderable'     => true,
                'width'=>"3%",
                'defaultContent'=> '0',
            ]),

            'consultant_name' => new Column([
                'title' => __('models/workOrders.fields.consultant_name'),
                'data' => 'consultant.name',
                'orderable'     => false,
                'defaultContent'=> ''
            ]),
            'drilling_worker' => new Column([
                'title' => 'المنفذ لاعمال الحفر',
                'data' => 'drilling_worker',
                //'width'=>"3%",
                'orderable'     => true,
                'searchable'     => false,
                'printable'  => true,
                "defaultContent"=> ''
            ]),
            'permit_woking_days' => new Column([
                'title' => __('models/workOrders.fields.permit_woking_days'),
                'data' => 'permit_woking_days',
                'width' => "3%",
                'orderable' => true,
                'searchable' => false,
                'printable' => true,
                'defaultContent' => '',
                'render' => 'function () {
                    console.log(row.total_period > 15 && data === null);
                    if (data === null || typeof data === "undefined") {
                        return " ";


                    }else if(data >= 15 && data < row.total_period) {
                        return ( \'<span class="text-warning" data-toggle="tooltip" title="\' + data + \'">\' + data + \'</span>\'  );


                    }else if(data >= 15 && data >= row.total_period){
                        return ( \'<span class="text-danger" data-toggle="tooltip" title="\' + data + \'">\' + data + \'</span>\'  );

                        
                    }else{
                        return ( \'<span data-toggle="tooltip" title="\' + data + \'">\' + data + \'</span>\'  );
                    }
                }'
                
            ]),
           
            'permit_status' => new Column([
                'title' => __('models/workOrders.fields.permit_status'),
                'data' => 'permit_status',
                'width'=>"13%",
                'printable'  =>false,
                "defaultContent"=> '',
                'orderable'     => true,
                'searchable'     => false,
                'render' => 'function() {
                                    var $status =' . $work_order_permit_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return "";
                                    }
                                    // return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                    return `
                                        <span class="badge rounded-pill ${$status[data].class}">
                                            <a 
                                                title="${row.work_type.full_name}" 
                                                href="/workOrdersManagement/workOrdersPermits/${row.permit_number_id}">
                                                ${$status[data].title}
                                            </a>
                                        </span>
                                    `;

                                    }'
            ]),
            'drilling_status' => new Column([
                'title' => 'حالة تنفيذ اعمال الحفر',
                'data' => 'drilling_status',
                'width'=>"3%",
                'orderable'     => true,
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
                'orderable'     => true,
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
                'width'=>"5%",
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
                'width'=>"1%",
                'printable'     => true,
                'visible'     => false,
                'searchable'     => false,
                'orderable'     => true,
                "defaultContent"=> ''
            ])

        ];
    }

}
