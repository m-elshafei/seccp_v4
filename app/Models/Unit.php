<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Unit
 * @package App\Models
 * @version January 14, 2022, 6:06 pm UTC
 *
 * @property string $name
 * @property string $code
 * @property string $name_ar
 * @property string $description
 */
class Unit extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'units';
    

   



    public $fillable = [
        'name',
        'code',
        'name_ar',
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
        'code' => 'string',
        'name_ar' => 'string',
        'description' => 'string',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'code' => 'required'
    ];

    
}
