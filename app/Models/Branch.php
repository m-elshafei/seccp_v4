<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Branch
 * @package App\Models
 * @version December 31, 2021, 11:04 pm UTC
 *
 * @property string $name
 * @property integer $city_id
 * @property integer $district_id
 * @property integer $is_main_branch
 */
class Branch extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'branches';
    

   



    public $fillable = [
        'name',
        'city_id',
        'district_id',
        'is_main_branch'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_id' => 'integer',
        'district_id' => 'integer',
        'is_main_branch' => 'integer',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    
}
