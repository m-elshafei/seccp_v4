<?php

namespace App\DataTables;

use App\Models\Job;
use Yajra\DataTables\Html\Column;

class JobDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'jobs';
        $this->actionViewBlade = 'jobs.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Job $model)
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
            'name' => new Column(['title' => __('models/jobs.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/jobs.fields.description'), 'data' => 'description']),
        ];
    }
}
