<?php

namespace App\DataTables;

use App\Models\EmergencyIssuesType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class EmergencyIssuesTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'emergency_issues_types';
        $this->actionViewBlade = 'emergency_issues_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EmergencyIssuesType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(EmergencyIssuesType $model)
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
            'name' => new Column(['title' => __('models/emergencyIssuesTypes.fields.name'), 'data' => 'name']),
            'description' => new Column(['title' => __('models/emergencyIssuesTypes.fields.description'), 'data' => 'description']),
        ];
    }

}
