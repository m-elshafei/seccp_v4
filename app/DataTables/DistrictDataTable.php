<?php

namespace App\DataTables;

use App\Models\District;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class DistrictDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'districts';
        $this->actionViewBlade = 'districts.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\District $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(District $model)
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
            'index'=> $this->getIndexCol(),
            // 'id' => new Column(['id' => __('id'), 'data' => 'id']),
            'name' => new Column(['title' => __('models/districts.fields.name'), 'data' => 'name']),
            'city_name' => new Column(['title' => __('models/districts.fields.city_name'), 'data' => 'city.name',"targets"=> "_all","defaultContent"=> "-",'orderable'      => false,]),
            
        ];
    }

}
