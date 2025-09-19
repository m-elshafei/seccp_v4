<?php

namespace App\DataTables;

use App\Models\Layer;
use Yajra\DataTables\Html\Column;

class LayerDataTable extends AppDataTable
{
    public function __construct()
    {
        $this->dataTableName = 'layers';
        $this->actionViewBlade = 'layers.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Layer $model)
    {
        return $model->newQuery()->orderBy('order')->orderBy('id');
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
            'name' => new Column(['title' => __('models/layers.fields.name'), 'data' => 'name']),
            'order' => new Column(['title' => __('models/layers.fields.order'), 'data' => 'order']),
            'is_final' => new Column([
                'title' => __('models/layers.fields.is_final'),
                'data' => 'is_final',
                'render' => 'function() {
                     if (data) {
                        return "نهائي";
                     }else{
                        return "-";
                     }
                }',
            ]),
        ];
    }
}
