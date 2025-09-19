<?php

namespace App\DataTables;

use App\Models\FinancialDueType;
use Yajra\DataTables\Html\Column;

class FinancialDueTypeDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'financial_due_types';
        $this->actionViewBlade = 'financial_due_types.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
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
            'index' => $this->getIndexCol(),
            'name' => new Column(['title' => __('models/financialDueTypes.fields.name'), 'data' => 'name']),
        ];
    }
}
