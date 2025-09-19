<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class District
 *
 * @version December 26, 2021, 8:21 pm UTC
 *
 * @property \App\Models\City $city
 * @property string $name
 * @property int $city_id
 */
class District extends AppBaseModel
{
    use CreatedUpdatedBy,LogsActivity , SoftDeletes;

    public $table = 'districts';

    public $fillable = [
        'name',
        'city_id',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('District')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }
}
