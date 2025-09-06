<?php

namespace App\DataTables;

use App\Models\WorkOrderTransactionsHistory;
use Yajra\DataTables\Html\Column;
use App\DataTables\AppDataTable;

class WorkOrderTransactionsHistoryDataTable extends AppDataTable
{
    function __construct() {
        $this->dataTableName = 'workOrderTransactionsHistories';
        $this->actionViewBlade = 'work_order_transactions_histories.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrderTransactionsHistory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrderTransactionsHistory $model)
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
            'work_order_id' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.work_order_id'), 'data' => 'work_order_id']),
            'user_id' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.user_id'), 'data' => 'user_id']),
            'work_order_number' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.work_order_number'), 'data' => 'work_order_number']),
            'old_status' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.old_status'), 'data' => 'old_status']),
            'new_status' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.new_status'), 'data' => 'new_status']),
            'old_department' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.old_department'), 'data' => 'old_department']),
            'new_department' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.new_department'), 'data' => 'new_department']),
            'type' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.type'), 'data' => 'type']),
            'description' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.description'), 'data' => 'description']),
            'note' => new Column(['title' => __('models/workOrderTransactionsHistories.fields.note'), 'data' => 'note'])
        ];
    }

    
}
