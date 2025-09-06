<?php

namespace App\DataTables;

use App\Models\Contractor;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class ContractorDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'contractors';
        $this->actionViewBlade = 'contractors.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Contractor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contractor $model)
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
            'id' => new Column(['title' => __('models/contractors.fields.id'), 'data' => 'id']),
            'name' => new Column(['title' => __('models/contractors.fields.name'), 'data' => 'name']),
            'company_name' => new Column(['title' => __('models/contractors.fields.company_name'), 'data' => 'company_name']),
            'contact_name' => new Column(['title' => __('models/contractors.fields.contact_name'), 'data' => 'contact_name']),
            'contact_mobile_number' => new Column(['title' => __('models/contractors.fields.contact_mobile_number'), 'data' => 'contact_mobile_number']),
            'notes' => new Column(['title' => __('models/contractors.fields.notes'), 'data' => 'notes'])
        ];
    }

}
