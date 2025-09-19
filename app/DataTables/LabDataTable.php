<?php

namespace App\DataTables;

use App\Models\Lab;
use Yajra\DataTables\Html\Column;

class LabDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'labs';
        $this->actionViewBlade = 'labs.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lab $model)
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
            'name' => new Column(['title' => __('models/labs.fields.name'), 'data' => 'name']),
        ];
    }
}
