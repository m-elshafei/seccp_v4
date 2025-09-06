<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class AssayService
 * @package App\Models
 * @version March 15, 2022, 2:16 pm UTC
 *
 * @property integer $assay_form_id
 * @property integer $service_id
 * @property integer $quantity
 */
class AssayService extends AppBaseModel
{
    use SoftDeletes, LogsActivity, Branchable , CreatedUpdatedBy;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('AssayService')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }


    public $table = 'assay_services';
    

   



    public $fillable = [
        'assay_form_id',
        'service_id',
        'quantity',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'assay_form_id' => 'integer',
        'service_id' => 'integer',
        'quantity' => 'float',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'assay_form_id' => 'required',
        'service_id'    => 'required|exists:work_order_services,id',
        'quantity'      => 'required|gt:0'
    ];

    protected $appends = [
        'service_name',
        'service_code',
        'service_price',
    ];


    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\AssayService']);
    }

    public function service(){
        return $this->belongsTo(WorkOrderService::class,'service_id','id')->withDefault();
    }

    public function getServiceNameAttribute(){
        $row = $this->belongsTo(WorkOrderService::class,'service_id','id')->first();
        if ($row){
            return $row->name ?? '';
        }
        return '';
    }

    public function getServiceCodeAttribute(){
        $row = $this->belongsTo(WorkOrderService::class,'service_id','id')->first();
        if ($row){
            return $row->code ?? '';
        }
        return '';
    }

    public function getServicePriceAttribute(){
        $row = $this->belongsTo(WorkOrderService::class,'service_id','id')->first();
        if ($row){
            return $row->price ?? 0;
        }
        return 0;
    }
    
}
