<?php

namespace App\DataTables;

use App\Models\MissionType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class MissionTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'mission_types';
        $this->actionViewBlade = 'mission_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\MissionType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(MissionType $model)
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
            'name' => new Column(['title' => __('models/missionTypes.fields.name'), 'data' => 'name'])
        ];
    }

}
