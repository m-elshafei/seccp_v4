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

class ElectricalOperation extends AppBaseModel
{
    use SoftDeletes;
    use LogsActivity;
    use Branchable;
    use CreatedUpdatedBy;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ElectricalOperation')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }


    public $table = 'electrical_operations';


    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at'   =>'datetime'
    ];



    public $fillable = [
        'work_order_id',
        'user_id',
        'status',
        'electrical_complete_date',
        'tablun',
        'welding',
        'welding_type',
        'end',
        'end_type',
        'station_breaker',
        'total_electrical_counters',
        'electrical_worker_type',
        'electrical_employee_id',
        'electrical_contractor_id',
        'voltage',
        'outlet_no',
        'note'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\ElectricalOperation']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function workOrder(){
        return $this->belongsTo(WorkOrder::class,'work_order_id','id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class,'electrical_employee_id','id');
    }

    public function contractor(){
        return $this->belongsTo(Contractor::class,'electrical_contractor_id','id');
    }
}
