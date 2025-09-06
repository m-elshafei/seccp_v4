<?php

namespace App\DataTables;

use App\Models\WorkOrdersProject;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrdersProjectDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_projects';
        $this->actionViewBlade = 'work_orders_projects.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrdersProject $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrdersProject $model)
    {
        return $model->withCount(["projectSteps"])->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $project_status= json_encode(config("const.work_order_project_status"));
        return [
            'index'=> $this->getIndexCol(),
            'name' => new Column(['title' => __('models/workOrdersProjects.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/workOrdersProjects.fields.description'), 'data' => 'description']),
            // 'start_date' => new Column(['title' => __('models/workOrdersProjects.fields.start_date'), 'data' => 'start_date']),
            // 'end_date' => new Column(['title' => __('models/workOrdersProjects.fields.end_date'), 'data' => 'end_date']),
            
            'stages_count' => new Column(['title' => __('models/workOrdersProjects.fields.stages_count'), 'data' => 'stages_count']),
            'project_steps_count' => new Column(['title' => __('models/workOrdersProjects.fields.stages_count'), 'data' => 'project_steps_count']),
            'status' => new Column([
                'title' => __('models/workOrdersProjects.fields.status'),
                'data' => 'status',
                'render' => 'function() {
                                if (typeof data === "undefined") {
                                return "-";
                                }
                                var $status =' . $project_status   .';
                                if (typeof $status[data] === "undefined") {
                                return data;
                                }
                                return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                            }'
            ]),
        ];
    }

}
