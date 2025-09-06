<?php

namespace App\DataTables;

use App\Models\Employee;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class EmployeeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'employees';
        $this->actionViewBlade = 'employees.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->newQuery()->with(['department','job']);
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
            'name' => new Column(['title' => __('models/employees.fields.name'), 'data' => 'name']),
            // 'branch_id' => new Column(['title' => __('models/employees.fields.branch_id'), 'data' => 'branch_id']),
            'job_id' => new Column([
                'title' => __('models/employees.fields.job_name'), 
                'data' => 'job.name'
            ]),
            'department_id' => new Column([
                'title' => __('models/employees.fields.department_name'), 
                'data' => 'department.name'
            ]),
            
            // 'user_id' => new Column(['title' => __('models/employees.fields.user_id'), 'data' => 'user_id'])
        ];
    }

}
