<?php

namespace App\DataTables;

use App\Models\WorkOrderService;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class WorkOrderServiceDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'work_order_services';
        $this->actionViewBlade = 'work_order_services.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkOrderService $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkOrderService $model)
    {
        return $model->newQuery()->with(['servicesCategory','unit']);
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
            'code' => new Column(['title' => __('models/workOrderServices.fields.code'), 'data' => 'code']),
            // 'name' => new Column(['title' => __('models/workOrderServices.fields.name'), 'data' => 'name']),
            'name_ar' => new Column(['title' => __('models/workOrderServices.fields.name_ar'), 'data' => 'name_ar']),
            
            'price' => new Column(['title' => __('models/workOrderServices.fields.price'), 'data' => 'price']),
            // 'description' => new Column(['title' => __('models/workOrderServices.fields.description'), 'data' => 'description']),
            'unit_id' => new Column(['title' => __('models/workOrderServices.fields.unit_id'), 'data' => 'unit.name','searchable' => false]),
            'services_category_id' => new Column(['title' => __('models/workOrderServices.fields.services_category_id'), 'data' => 'services_category.name','searchable' => false])
        ];
    }

}
