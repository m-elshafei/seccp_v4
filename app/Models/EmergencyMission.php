<?php

namespace App\Models;

use App\Http\Traits\AttachmentTrait;
use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use App\Traits\CurrentOwner;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class EmergencyMission
 *
 * @version July 29, 2022, 12:22 pm UTC
 *
 * @property int $work_order_number
 */
class EmergencyMission extends WorkOrder
{
    use AttachmentTrait;
    use Branchable;
    use CreatedUpdatedBy;
    use CurrentOwner;
    use LogsActivity;
    use SoftDeletes;

    // public $table = 'emergency_missions';

    protected $appends = ['total_work_period', 'status_title'];

    public function getEmergencyMissions()
    {
        return $this->newQuery()->where('current_department_id', 5)->where('is_emergency_mission', 1);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('EmergencyMission')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    // public $fillable = [
    //     'work_order_number'
    // ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_order_number' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'mission_number' => 'required',
        'received_date' => 'required',
        'mission_typeـid' => 'required',
        // 'district_id' => 'required',
    ];

    public static $parent_work_order_rules = [
        'work_order_number' => 'required',
        'work_type_id' => 'required|numeric|gt:0',
    ];

    public function workOrdersPermits()
    {
        return $this->belongsToMany(WorkOrdersPermit::class, 'work_order_work_orders_permit', 'work_order_id', 'work_orders_permit_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\EmergencyMission']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function district()
    {
        return $this->belongsTo(\App\Models\District::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function receivedEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'mission_received_employee');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function currentDepartment()
    {
        return $this->belongsTo(\App\Models\Department::class, 'current_department_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function ownertDepartment()
    {
        return $this->belongsTo(\App\Models\Department::class, 'owner_department_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function workOrdersNotes()
    {
        return $this->hasMany(WorkOrderNote::class, 'work_order_id');
    }

    public function workOrdersPermitNote()
    {
        return $this->hasMany(WorkOrdersPermitNote::class, 'work_orders_permits_id');
    }

    public function emergencyMission()
    {
        return $this->hasOne(WorkOrderEmergencyMissions::class, 'work_order_id', 'id')->withDefault();
    }

    public function missionType()
    {
        return $this->belongsTo(MissionType::class, 'mission_typeـid', 'id')->withDefault();
    }

    /***********  Attributes  *****************/

    /**
     * Get the user's first name.
     */
    protected function totalWorkPeriod(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (! empty($attributes['received_date'])) {
                    try {
                        $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['received_date']);
                        $dt1 = Carbon::now();

                        return $dt2->diffInDays($dt1);
                    } catch (Carbon\Exceptions\InvalidFormatException $e) {
                        \Log::error('Invalid date format for received_date: '.$attributes['received_date']);

                        return null;
                    }
                } else {
                    return null;
                }
            }
        );

    }

    protected function statusTitle(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                return config('const.work_order_general_status.'.$attributes['status']);
            }
        );
    }
}
