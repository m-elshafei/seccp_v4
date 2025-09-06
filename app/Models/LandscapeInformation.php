<?php

namespace App\Models;

use App\Models\Employee;
use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LandscapeInformation extends AppBaseModel
{
    use SoftDeletes;
    use LogsActivity;
    use Branchable;
    use CreatedUpdatedBy;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('LandscapeInformation')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }


    public $table = 'landscape_information';


    protected $casts = [
        'deleted_at'   =>'datetime'
    ];



    public $fillable = [
        'work_order_id',
        'user_id',
        'scanned',
        'needs_welding_program',
        'obstacles_exist_on_site',
        'drilling_type',
        'drilling_deep',
        'drilling_layer',
        'landscape_date',
        'number_of_clips_dust',
        'number_of_clips_asphalt',
        'number_of_clips_sidewalk',
        'number_of_clips_total',
        'length_dust',
        'length_asphalt',
        'length_sidewalk',
        'length_total',
        'drilling_worker_type',
        'drilling_employee_id',
        'drilling_contractor_id',
        'length_dust_before',
        'length_asphalt_before',
        'length_sidewalk_before',
        'length_total_before',
        'drilling_complete_date',
        'cabel_length_hv',
        'cabel_length_lv70',
        'cabel_length_lv185',
        'cabel_length_lv300',
        'note'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\LandscapeInformation']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function workOrder(){
        return $this->belongsTo(WorkOrder::class,'work_order_id','id');
    }

    public function drillingEmployee()
    {
        return $this->belongsTo(Employee::class, 'drilling_employee_id', 'id');
    }
}
