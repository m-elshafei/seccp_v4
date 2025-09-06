<?php

namespace App\DataTables;

use App\Models\WorkOrdersType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrdersTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_types';
        $this->actionViewBlade = 'work_orders_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrdersType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrdersType $model)
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
            'name' => new Column(['title' => __('models/workOrdersTypes.fields.name'), 'data' => 'name']),
            // 'parent_id' => new Column(['title' => __('models/workOrdersTypes.fields.parent_id'), 'data' => 'parent_id'])
        ];
    }

}
