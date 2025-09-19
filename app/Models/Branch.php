<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Branch
 *
 * @version December 31, 2021, 11:04 pm UTC
 *
 * @property string $name
 * @property int $city_id
 * @property int $district_id
 * @property int $is_main_branch
 */
class Branch extends AppBaseModel
{
    use SoftDeletes;

    public $table = 'branches';

    public $fillable = [
        'name',
        'city_id',
        'district_id',
        'is_main_branch',
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
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
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
