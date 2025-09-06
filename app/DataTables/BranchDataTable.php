<?php

namespace App\DataTables;

use App\Models\Branch;
use App\DataTables\AppDataTable;
use Yajra\DataTables\Html\Column;

class BranchDataTable extends AppDataTable
{


    function __construct() {
        $this->dataTableName = 'branches';
        $this->actionViewBlade = 'branches.datatables_actions';
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Branch $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Branch $model)
    {
        return $model->newQuery()->with(["city","district"]);
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
            'name' => new Column(['title' => __('models/branches.fields.name'), 'data' => 'name']),
            'city_name' => new Column(['title' => __('models/branches.fields.city_name'), 'data' => 'city.name',"targets"=> "_all","defaultContent"=> "-",'orderable' => false,]),
            // 'district_name' => new Column(['title' => __('models/branches.fields.district_name'), 'data' => 'districts.name',"targets"=> "_all","defaultContent"=> "-",'orderable' => false]),
            'is_main_branch' => new Column([
                'title' => __('models/branches.fields.is_main_branch'), 
                'data' => 'is_main_branch',
                'render' => 'function() {
                    if(data){
                        return "نعم"
                    }
                    return "لا";
                }'
            ])
        ];
    }

}
