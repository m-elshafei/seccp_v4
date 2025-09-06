<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Job
 * @package App\Models
 * @version February 14, 2022, 2:47 pm UTC
 *
 * @property string $name
 * @property string $description
 */
class Job extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'jobs';


    public $fillable = [
        'name',
        'description',
        'is_workersـsupervisor'
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

    
}
