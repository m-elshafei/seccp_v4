<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ElectricalStationsType
 * @package App\Models
 * @version January 6, 2022, 11:57 am UTC
 *
 * @property string $name
 * @property string $code
 * @property integer $electrical_type
 * @property string $description
 */
class ElectricalStationsType extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'electrical_stations_types';
    

   



    public $fillable = [
        'name',
        'code',
        'electrical_type',
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
        'electrical_type' => 'integer',
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
