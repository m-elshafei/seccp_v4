<?php

namespace App\DataTables;

use App\Http\Controllers\ElectricalStationsTypeController;
use App\Models\ElectricalStationsType;
use Yajra\DataTables\Html\Column;

class ElectricalStationsTypeDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'electrical_stations_types';
        $this->actionViewBlade = 'electrical_stations_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ElectricalStationsType $model)
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
        $electrical_type = json_encode(ElectricalStationsTypeController::electricalTypes);

        return [
            'name' => new Column(['title' => __('models/electricalStationsTypes.fields.name'), 'data' => 'name']),
            'code' => new Column(['title' => __('models/electricalStationsTypes.fields.code'), 'data' => 'code']),
            'electrical_type' => new Column([
                'title' => __('models/electricalStationsTypes.fields.electrical_type'),
                'data' => 'electrical_type',
                'render' => 'function() {
                        var $status ='.$electrical_type.';
                           if (typeof $status[data] === "undefined") {
                            return data;
                           }
                            return $status[data];
                        }',
            ]),
            'description' => new Column(['title' => __('models/electricalStationsTypes.fields.description'), 'data' => 'description']),
        ];
    }
}
