<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WorkOrdersProject
 * @package App\Models
 * @version February 12, 2022, 12:12 pm UTC
 *
 * @property string $name
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property integer $stages_count
 */
class WorkOrdersProject extends AppBaseModel
{
    use SoftDeletes, Branchable , CreatedUpdatedBy;


    public $table = 'work_orders_projects';
    

   



    public $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'stages_count',
        'closed_work_order_number',
        'copy_from_work_order_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
        'stages_count' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'project_id' , 'id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function projectSteps()
    {
        return $this->hasMany(WorkOrder::class, 'project_id' , 'id')->whereNotNull('project_stage_id');
    }

    
}
