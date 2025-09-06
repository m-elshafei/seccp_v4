<?php

namespace App\DataTables;

use App\Models\FinancialDueType;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class FinancialDueTypeDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'financial_due_types';
        $this->actionViewBlade = 'financial_due_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FinancialDueType $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinancialDueType $model)
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
            'name' => new Column(['title' => __('models/financialDueTypes.fields.name'), 'data' => 'name'])
        ];
    }

}
