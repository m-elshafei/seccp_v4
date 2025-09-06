<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WorkOrdersStage
 * @package App\Models
 * @version January 14, 2022, 2:45 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $departments
 * @property integer $name
 * @property integer $default_next_stage_id
 * @property integer $parent_id
 */
class WorkOrdersStage extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'work_orders_stages';
    

   



    public $fillable = [
        'name',
        'default_next_stage_id',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'integer',
        'default_next_stage_id' => 'integer',
        'parent_id' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function departments()
    {
        return $this->belongsToMany(\App\Models\Departments::class, 'work_orders_stages_departments', 'departments_id', 'work_orders_stages_id');
    }
}
