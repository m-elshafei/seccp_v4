<?php

namespace App\DataTables;

use App\Models\ElectricityDepartment;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class ElectricityDepartmentDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'electricity_departments';
        $this->actionViewBlade = 'electricity_departments.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ElectricityDepartment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ElectricityDepartment $model)
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
            'name' => new Column(['title' => __('models/electricityDepartments.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/electricityDepartments.fields.description'), 'data' => 'description'])
        ];
    }

}
