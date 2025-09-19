<?php

namespace App\DataTables;

use App\Models\Unit;
use Yajra\DataTables\Html\Column;

class UnitDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'units';
        $this->actionViewBlade = 'units.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Unit $model)
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
            'index' => $this->getIndexCol(),
            'name' => new Column(['title' => __('models/units.fields.name'), 'data' => 'name']),
            'code' => new Column(['title' => __('models/units.fields.code'), 'data' => 'code']),
            'name_ar' => new Column(['title' => __('models/units.fields.name_ar'), 'data' => 'name_ar']),
            'description' => new Column(['title' => __('models/units.fields.description'), 'data' => 'description']),
        ];
    }
}
