<?php

namespace App\DataTables;

use App\Http\Controllers\ElectricalStationsTypeController;
use App\Models\ElectricityCompanyEmployees;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class ElectricityCompanyEmployeeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'electricity_company_employees';
        $this->actionViewBlade = 'electricity_company_employees.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ElectricityCompanyEmployees $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ElectricityCompanyEmployees $model)
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
            'index'=> $this->getIndexCol(),
            'name' => new Column(['title' => __('models/electricityCompanyEmployees.fields.name'), 'data' => 'name']),
        ];
    }

}
