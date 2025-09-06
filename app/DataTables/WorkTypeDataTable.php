<?php

namespace App\DataTables;

use App\Models\WorkType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_types';
        $this->actionViewBlade = 'work_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkType $model)
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
            'code' => new Column(['title' => __('models/workTypes.fields.code'), 'data' => 'code']),
            'name' => new Column(['title' => __('models/workTypes.fields.name'), 'data' => 'name']),
            // 'notes' => new Column(['title' => __('models/workTypes.fields.notes'), 'data' => 'notes']),
            // 'needs_drilling_operations' => new Column(['title' => __('models/workTypes.fields.needs_drilling_operations'), 'data' => 'needs_drilling_operations']),
            'needs_drilling_operations' => new Column([
                'title' => __('models/workTypes.fields.needs_drilling_operations'), 
                'data' => 'needs_drilling_operations',
                'render' => 'function() {
                    if(data){
                        return "نعم"
                    }
                    return "لا";
                }'
            ]),
            // 'needs_electrical_work' => new Column(['title' => __('models/workTypes.fields.needs_electrical_work'), 'data' => 'needs_electrical_work']),
            'needs_electrical_work' => new Column([
                'title' => __('models/workTypes.fields.needs_electrical_work'), 
                'data' => 'needs_electrical_work',
                'render' => 'function() {
                    if(data){
                        return "نعم"
                    }
                    return "لا";
                }'
            ]),
            // 'needs_work_orders_permit' => new Column(['title' => __('models/workTypes.fields.needs_work_orders_permit'), 'data' => 'needs_work_orders_permit'])
            'needs_work_orders_permit' => new Column([
                'title' => __('models/workTypes.fields.needs_work_orders_permit'), 
                'data' => 'needs_work_orders_permit',
                'render' => 'function() {
                    if(data){
                        return "نعم"
                    }
                    return "لا";
                }'
            ])
        ];
    }

}
