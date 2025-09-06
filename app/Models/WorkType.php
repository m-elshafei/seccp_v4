<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WorkType
 * @package App\Models
 * @version January 6, 2022, 10:38 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $depatments
 * @property string $code
 * @property string $name
 * @property string $notes
 * @property boolean $needs_drilling_operations
 * @property boolean $needs_electrical_work
 * @property boolean $needs_work_orders_permit
 */
class WorkType extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'work_types';
    

   

    protected $appends = ['full_name' , 'full_name_to_permit'];


    public $fillable = [
        'code',
        'name',
        'notes',
        'needs_drilling_operations',
        'needs_electrical_work',
        'needs_work_orders_permit',
        'default_department_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'notes' => 'string',
        'needs_drilling_operations' => 'boolean',
        'needs_electrical_work' => 'boolean',
        'needs_work_orders_permit' => 'boolean',
        'default_department_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'name' => 'required'
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function depatments()
    {
        return $this->belongsToMany(\App\Models\Depatment::class, 'work_types_depatments', 'work_type_id', 'department_id');
    }


    public function getFullNameAttribute()
    {
        return "{$this->code} - ({$this->name})";
    }

    public function getFullNameToPermitAttribute()
    {
        return "({$this->code} - {$this->name})";
    }
}
