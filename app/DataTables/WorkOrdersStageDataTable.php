<?php

namespace App\DataTables;

use App\Models\WorkOrdersStage;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrdersStageDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_stages';
        $this->actionViewBlade = 'work_orders_stages.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrdersStage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrdersStage $model)
    {
        return $model->newQuery();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'index'=> $this->getIndexCol(),
            'name' => new Column(['title' => __('models/workOrdersStages.fields.name'), 'data' => 'name']),
            'default_next_stage_id' => new Column(['title' => __('models/workOrdersStages.fields.default_next_stage_id'), 'data' => 'default_next_stage_id']),
            'parent_id' => new Column(['title' => __('models/workOrdersStages.fields.parent_id'), 'data' => 'parent_id'])
        ];
    }

}
