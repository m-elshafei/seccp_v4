<?php

namespace App\DataTables;

use App\Models\Consultant;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class ConsultantDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'consultants';
        $this->actionViewBlade = 'consultants.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Consultant $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Consultant $model)
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
            'id' => new Column(['title' => __('models/consultants.fields.id'), 'data' => 'id']),
            'name' => new Column(['title' => __('models/consultants.fields.name'), 'data' => 'name'])
        ];
    }

}
