<?php

namespace App\DataTables;

use App\Models\WorkOrder;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrderDrillingProjectsDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders';
        $this->actionViewBlade = 'work_orders.datatables_actions';
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
        // return $model->newQuery()->with(["district","workType","currentDepartment"]);
        return $model->getDrillingProjectWorkOrders()->with(["district","workType","landscape","project"]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $work_order_status= json_encode(config("const.work_order_general_status"));
        return [
            'index'=> $this->getIndexCol(),
            'work_order_number' => new Column(['title' => __('models/workOrders.fields.work_order_number'), 'data' => 'work_order_number']),
            'received_date' => new Column(['title' => __('models/workOrders.fields.received_date'), 'data' => 'received_date']),
            'work_type_id' => new Column([
                'title' => __('models/workOrders.fields.work_type_name'), 
                'data' => 'work_type.full_name',
                'width'=>"5%",
                'orderable'      => false,
                'searchable'     => false,//return '<a href="'+data+'">Download</a>';( data, type, row, meta )
                "render"=> 'function () {
                    console.log(meta.data);
                    row=meta.settings.aoData[meta.row]._aData;
                    return \'<a title="\'+data+\'" href="/workOrdersManagement/workTypes/\'+row.work_type.id+\'">\'+row.work_type.code+\'</a>\'
                  }'
            ]),
            'district_id' => new Column(['title' => __('models/workOrders.fields.district_name'), 'data' => 'district.name']),
            // 'current_department_id' => new Column([
            //     'title' => __('models/workOrders.fields.current_department_name'), 
            //     'data' => 'current_department.name',
            //     'name' => 'currentDepartment.name',
            //     'orderable'      => false,
            //     'searchable'     => true,
            //     "defaultContent"=> '<span class="badge rounded-pill badge-light-danger">غير مربوط بادارة</span>'
            // ]),
            'project_id' => new Column(['title' => __('models/workOrders.fields.project_name'), 'data' => 'project.name',
            "render"=> 'function () {
                console.log(meta.data);
                row=meta.settings.aoData[meta.row]._aData;
                return \'<a title="\'+data+\'" href="/workOrdersManagement/workOrdersProjects/\'+row.project_id+\'">\'+row.project.name+\'</a>\'
              }'
            ]),
            'project_stage_id' => new Column(['title' => __('models/workOrders.fields.project_stage_id'), 'data' => 'project_stage_id']),
            'total_work_period' => new Column([
                'title' => __('models/workOrders.fields.total_work_period'), 
                'data' => 'total_work_period',
                'orderable'      => false,
                'searchable'     => false,
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
            ])
        ];
    }

}
