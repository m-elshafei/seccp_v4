<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class ElectricityTower extends AppBaseModel
{
    use Branchable;
    use CreatedUpdatedBy;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ElectricityTower')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public $fillable = [
        'work_order_id',
        'user_id',
        'tower10',
        'tower13',
        'converter',
        'shadad',
        'grid_high_voltage',
        'grid_low_voltage',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function activities()
    {
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\ElectricityTower']);
    }
}
