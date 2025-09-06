<?php

namespace App\DataTables;

use App\Models\FinancialDue;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class FinancialDueDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'financial_dues';
        $this->actionViewBlade = 'financial_dues.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\FinancialDue $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(FinancialDue $model)
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
        $financial_status= json_encode(config("const.financial_due_status_list"));
        return [
            'due_no' => new Column(['title' => __('models/financialDues.fields.due_no'), 'data' => 'due_no']),
            'due_date' => new Column(['title' => __('models/financialDues.fields.due_date'), 'data' => 'due_date']),
            
            // 'financial_due_type_id' => new Column(['title' => __('models/financialDues.fields.financial_due_type_id'), 'data' => 'financial_due_type_id']),
            // 'electricity_department_id' => new Column(['title' => __('models/financialDues.fields.electricity_department_id'), 'data' => 'electricity_department_id']),
            'total_amount' => new Column(['title' => __('models/financialDues.fields.total_amount'), 'data' => 'total_amount']),
            'total_fines_amount' => new Column(['title' => __('models/financialDues.fields.total_fines_amount'), 'data' => 'total_fines_amount']),
            'total_net_amount' => new Column(['title' => __('models/financialDues.fields.total_net_amount'), 'data' => 'total_net_amount']),
            'total_final_amount' => new Column(['title' => __('models/financialDues.fields.total_final_amount'), 'data' => 'total_final_amount']),
            
            'notes' => new Column(['title' => __('models/financialDues.fields.notes'), 'data' => 'notes']),
            'status' => new Column([
                'title' => __('models/financialDues.fields.status'),
                'data' => 'status',
                'render' => 'function() {
                                    var $status =' . $financial_status   .';
                                    if (typeof $status[data] === "undefined") {
                                    return data;
                                    }
                                    return ( \'<span class="badge rounded-pill \' + $status[data].class + \'">\' + $status[data].title + \'</span>\'  );
                                }'
            ]),
        ];
    }

}
