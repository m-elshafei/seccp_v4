<?php

namespace App\DataTables;

use App\Models\WorkOrdersPermitType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrdersPermitTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_orders_permit_types';
        $this->actionViewBlade = 'work_orders_permit_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrdersPermitType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrdersPermitType $model)
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
            'name' => new Column(['title' => __('models/workOrdersPermitTypes.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/workOrdersPermitTypes.fields.description'), 'data' => 'description'])
        ];
    }

}
