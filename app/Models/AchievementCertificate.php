<?php

namespace App\Models;

use App\Models\WorkOrder;
use App\Traits\Branchable;


use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AchievementCertificate
 * @package App\Models
 * @version May 15, 2022, 5:41 pm UTC
 *
 * @property integer $work_order_id
 * @property integer $cert_date
 * @property integer $status
 * @property number $amount
 * @property number $fines_amount
 * @property number $net_amount
 * @property string $notes
 */
class AchievementCertificate extends AppBaseModel
{
    use LogsActivity;
    use SoftDeletes;
    use Branchable;
    use CreatedUpdatedBy;



    public $table = 'achievement_certificates';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('AchievementCertificate')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $fillable = [
        'work_order_id',
        'cert_date',
        'status',
        'amount',
        'fines_amount',
        'net_amount',
        'final_amount',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_order_id' => 'integer',
        'cert_date' => 'date:Y-m-d',
        'status' => 'integer',
        'amount' => 'decimal:2',
        'fines_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'work_order_id' => 'required|numeric',
        //'amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'fines_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'net_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'cert_date' => 'required|date',
    ];

    
    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }
    

    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\AchievementCertificate']);
    }
}
