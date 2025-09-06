<?php

namespace App\DataTables;

use App\Models\Balady;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class BaladyDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'baladies';
        $this->actionViewBlade = 'baladies.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Balady $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Balady $model)
    {
        return $model->newQuery()->with("city");
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => new Column(['title' => __('models/baladies.fields.id'), 'data' => 'id']),
            'name' => new Column(['title' => __('models/baladies.fields.name'), 'data' => 'name']),
            'city_name' => new Column(['title' => __('models/districts.fields.city_name'), 'data' => 'city.name',"targets"=> "_all","defaultContent"=> "-",'orderable'      => false,]),
        ];
    }

}
