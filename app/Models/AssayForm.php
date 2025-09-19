<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class AssayForm
 *
 * @version March 12, 2022, 2:54 pm UTC
 *
 * @property int $work_order_id
 * @property int $district_id
 * @property int $work_type_id
 * @property string $customer_name
 * @property string $notes
 * @property int $status
 */
class AssayForm extends AppBaseModel
{
    use Branchable, CreatedUpdatedBy,LogsActivity , SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('AssayForm')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $table = 'assay_forms';

    public $fillable = [
        'work_order_id',
        'is_mission',
        'work_type_id',
        'notes',
        'amount',
        'status',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_order_id' => 'integer',
        'work_type_id' => 'integer',
        'notes' => 'string',
        'status' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'is_mission' => 'required|in:0,1',
        'work_order_id' => 'required_if:is_mission,0',
        'mission_id' => 'required_if:is_mission,1',
        // 'status' => 'required|in:1,2'
    ];

    public static $updateRules = [
        'work_order_id' => 'required_if:is_mission,0',
        'mission_id' => 'required_if:is_mission,1',
    ];

    protected $appends = ['status_name'];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\AssayForm']);
    }

    public function assayService()
    {
        return $this->hasMany(\App\Models\AssayService::class, 'assay_form_id');
    }

    public function assayItem()
    {
        return $this->hasMany(\App\Models\AssayItem::class, 'assay_form_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function workType()
    {
        return $this->belongsTo(\App\Models\WorkType::class, 'work_type_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function workOrder()
    {
        return $this->belongsTo(\App\Models\WorkOrder::class, 'work_order_id', 'id');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->toDateString();
    }

    public function getStatusNameAttribute()
    {
        return $this->attributes['status'] == 1 ? 'جديد' : 'معتمد';
    }
}
