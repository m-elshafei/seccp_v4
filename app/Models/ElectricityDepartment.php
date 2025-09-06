<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ElectricityDepartment
 * @package App\Models
 * @version January 6, 2022, 9:48 am UTC
 *
 * @property string $name
 * @property string $description
 */
class ElectricityDepartment extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'electricity_departments';
    

   



    public $fillable = [
        'name',
        'description'
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
