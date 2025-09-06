<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ElectricMeter extends AppBaseModel
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;
    use Branchable;
    use CreatedUpdatedBy;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ElectricMeter')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    protected $casts = [
        'deleted_at'   =>'datetime'
    ];

    public $fillable = [
        'work_order_id',
        'meter_no',
        'subscription_no',
        'reading',
        'previous_capacity',
        'approved_capacity',
        'user_id'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subscription_no'   => 'required',
        'meter_no'          => 'required',
        'reading'           => 'required|numeric|gte:0',
        'previous_capacity' => 'required|numeric|gte:0',
        'approved_capacity' => 'required|numeric|gte:0',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\ElectricMeter']);
    }
}
