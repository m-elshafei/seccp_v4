<?php

namespace App\DataTables;

use App\Models\Department;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class DepartmentDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'departments';
        $this->actionViewBlade = 'departments.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Department $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Department $model)
    {
        return $model->newQuery()->with("branch");
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
            'name' => new Column(['title' => __('models/departments.fields.name'), 'data' => 'name']),
            'branch_name' => new Column(['title' => __('models/departments.fields.branch_name'), 'data' => 'branch.name']),
            'description' => new Column(['title' => __('models/departments.fields.description'), 'data' => 'description'])
        ];
    }

}
