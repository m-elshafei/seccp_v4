<?php

namespace App\DataTables;

use App\Models\EmergencyMissionsV;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class EmergencyMissionDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'emergency_missions';
        $this->actionViewBlade = 'emergency_missions.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmergencyMissionsV $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmergencyMissionsV $model)
    {
        // dd($model->newQuery()->where("is_emergency_mission",1)->with(['currentDepartment','district','parent'])->all());
        return $model->newQuery()->where("is_emergency_mission",1)->with(['currentDepartment','district','parent','missionType']);
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
            'mission_number' => new Column(['title' => __('models/emergencyMissions.fields.mission_number'), 'data' => 'mission_number']),
            'mission_typeـid' => new Column(['title' => __('models/emergencyMissions.fields.mission_typeـid'),
            'data' => 'mission_type_name',
            'orderable' => false,
            'searchable' => true,
            ]),

            'permit_number' => new Column(['title' => __('models/workOrders.fields.permit_number'), 'data' => 'permit_number' ?? 0,'defaultContent'=> 'لا يوجد',]),
            'received_date' => new Column(['title' => __('models/workOrders.fields.received_date'), 'data' => 'received_date']),
// 'district_id' => new Column(['title' => __('models/workOrders.fields.district_name'), 'data' => 'district.name','width'=>"10%","defaultContent"=> '']),
            'current_department_id' => new Column([
                'title' => __('models/workOrders.fields.current_department_name'),
                'data' => 'current_department.name',
                'name' => 'currentDepartment.name',
                'orderable'      => false,
                'searchable'     => true,
                "defaultContent"=> '<span class="badge rounded-pill badge-light-danger">غير مربوط بادارة</span>'
            ]),
            'created_user_department_id' => new Column([
                'title' => 'القسم المنشئ لامر العمل',
                'data' => 'created_user_department_name',
                'name' => 'created_user_department_name',
                'orderable'      => false,
                'searchable'     => true,
                "defaultContent"=> '<span class="badge rounded-pill badge-light-danger">غير مربوط بادارة</span>'
            ]),
            'customer_number' => new Column(['title' => __('models/emergencyMissions.fields.customer_number'), 'data' => 'customer_number']),
            'purchase_number' => new Column(['title' => 'رقم امر الشراء', 'data' => 'purchase_number','width'=>"20%"]),

            'description' => new Column(['title' => __('models/emergencyMissions.fields.description'), 'data' => 'description','width'=>"15%"]),
            // 'mission_received_employee_name' => new Column([
            //     'title' => __('models/emergencyMissions.fields.mission_received_employee_short'),
            //     'data' => 'mission_received_employee_name',
            //     'orderable'      => false,
            //     'searchable'     => true,
            //     'defaultContent'=>'']),
            'electrical_station_number' => new Column(['title' => 'المحطه', 'data' => 'electrical_station_number','width'=>"20%"]),

            'parent_work_order' => new Column([
                'title' => __('models/emergencyMissions.fields.work_order_number'),
                'data' => 'parent_work_order',
                'defaultContent'=> '',
                'searchable'     => true,
                'orderable'      => true,
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
            ])
            // 'total_work_period' => new Column([
            //     'title' => __('models/workOrders.fields.total_work_period'),
            //     'data' => 'total_work_period',
            //     'width'=>"5%",
            //     'orderable'      => false,
            //     'searchable'     => false,
            // ]),
        ];
    }

}
