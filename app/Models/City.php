<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class City
 *
 * @version December 4, 2021, 8:20 pm UTC
 *
 * @property string $name
 */
class City extends AppBaseModel
{
    use CreatedUpdatedBy, LogsActivity , SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('City')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $table = 'cities';

    public $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
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

    public function activities()
    {
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\City']);
    }
}
