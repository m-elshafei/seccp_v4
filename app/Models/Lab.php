<?php

namespace App\Models;

use App\Traits\Branchable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Lab
 *
 * @version March 25, 2022, 1:41 pm UTC
 *
 * @property string $name
 */
class Lab extends AppBaseModel
{
    use Branchable;
    use LogsActivity;
    use SoftDeletes;

    public $table = 'labs';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Lab')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

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
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\Lab']);
    }
}
