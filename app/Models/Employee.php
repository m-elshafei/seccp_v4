<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Employee
 * @package App\Models
 * @version January 3, 2022, 1:22 am UTC
 *
 * @property \App\Models\Branch $branch
 * @property \App\Models\Department $department
 * @property \App\Models\Job $job
 * @property \App\Models\User $user
 * @property string $name
 * @property integer $branch_id
 * @property integer $department_id
 * @property integer $job_id
 * @property integer $user_id
 */
class Employee extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'employees';
    

   



    public $fillable = [
        'name',
        'branch_id',
        'department_id',
        'job_id',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'branch_id' => 'integer',
        'department_id' => 'integer',
        'job_id' => 'integer',
        'user_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'branch_id' => 'required',
        'department_id' => 'required',
        'job_id' => 'required'
    ];


    protected function getDisplayNameAttribute()
    {
        return $this->attributes['id'].' / '.$this->attributes['name'];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function job()
    {
        return $this->belongsTo(\App\Models\Job::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class)->withDefault();
    }
}
