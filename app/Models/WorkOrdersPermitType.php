<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WorkOrdersPermitType
 * @package App\Models
 * @version January 6, 2022, 11:04 am UTC
 *
 * @property string $name
 * @property string $description
 */
class WorkOrdersPermitType extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'work_orders_permit_types';
    

   



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
