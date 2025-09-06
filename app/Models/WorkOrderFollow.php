<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\AppBaseModel;
use Spatie\Activitylog\LogOptions;
use App\Http\Traits\AttachmentTrait;
use Spatie\Activitylog\Models\Activity;


use App\Enums\WorkOrderPermitStatusEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class WorkOrderFollow
 * @package App\Models
 * @version May 7, 2022, 6:46 pm UTC
 *
 * @property integer $work_order_number
 */
class WorkOrderFollow extends AppBaseModel
{
    use SoftDeletes;
    use AttachmentTrait;


    public $table = 'work_orders_permits';






    public $fillable = [
        'permit_number',
        'work_orders_permit_type_id',
        'sadad_number',
        'issued_amount',
        'total_amount',
        'total_extend_amount',
        'total_fines_amount',
        'period',
        'issue_date',
        'start_date',
        'end_date',
        'notes',
        'status',
        'refuse_reason',
        'completion_certificate_status',
        'completion_certificate_date',
        'clearance_certificate_status',
        'clearance_certificate_date',

        'clearance_sdad_number',
        'clearance_sdad_date',
        'clearance_sdad_amount',
    ];

    protected $appends = ['total_permit_period','total_permit_period_percentage','total_permit_period_day'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'permit_number' => 'string',
        'work_orders_permit_type_id' => 'integer',
        'sadad_number' => 'integer',
        'issued_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'total_extend_amount' => 'decimal:2',
        'total_fines_amount' => 'decimal:2',
        'period' => 'integer',
        'issue_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    // public static $rules = [
    //     'permit_number' => 'required_without:sadad_number|nullable|numeric',
    //     'sadad_number' => 'required_without:permit_number|nullable|numeric',
    //     'work_orders_permit_type_id' => 'required',
    //     'issue_date' => 'required|date',
    //     'end_date' => 'required|date',
    //     'work_order_id' => 'required',
    //     'issued_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
    // ];
    public static $rules = [];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules_update = [
        'permit_number' => 'required_without:sadad_number|nullable|numeric',
        'sadad_number' => 'required_without:permit_number|nullable|numeric',
        'work_orders_permit_type_id' => 'required',
        'issue_date' => 'required|date',
        'end_date' => 'required|date',
        'issued_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/'
    ];

    /************************************ */
    public function getRestablishWorkOrders()
    {
        return $this->newQuery()
                    ->whereIn("status" , [
                        WorkOrderPermitStatusEnum::PaidAndIssued , // [3,4,5,6,7] تم السداد والاصدار  -- تم تسليم التصريح
                        WorkOrderPermitStatusEnum::UnderWay ,
                        WorkOrderPermitStatusEnum::UnderDelivery,
                        WorkOrderPermitStatusEnum:: InitialDelivery,
                        WorkOrderPermitStatusEnum:: FinalDelivery,
                        WorkOrderPermitStatusEnum::WaitingForProcess,
                        ])
                    // ->where("work_orders_permit_type_id" , 1)->has("restablishWorkOrders");// 1 for baldya type
                    ->where("work_orders_permit_type_id" , 1);// 1 for baldya type
    }
    public function getRestablishDailyWorkOrders()
    {
        return $this->newQuery()
            ->whereIn("status" , [
                WorkOrderPermitStatusEnum::UnderWay ,
                WorkOrderPermitStatusEnum::UnderDelivery,
//                WorkOrderPermitStatusEnum:: InitialDelivery,
//                WorkOrderPermitStatusEnum:: FinalDelivery,
                WorkOrderPermitStatusEnum::WaitingForProcess,
            ])
            ->whereNotNull('restablish_convert_date')
            // ->where("work_orders_permit_type_id" , 1)->has("restablishWorkOrders");// 1 for baldya type
            ->where("work_orders_permit_type_id" , 1);// 1 for baldya type
    }
    /*********************************** */

    public function landLayers()
    {
        return $this->hasMany(LandLayer::class , 'work_orders_permit_id' , 'id' );
    }

    public function landLayersHistory()
    {
        return $this->hasMany(LandLayerHistory::class , 'work_orders_permit_id' , 'id' );
    }


    public function workOrdersPermitType()
    {
        return $this->belongsTo(\App\Models\WorkOrdersPermitType::class);
    }


    public function workOrdersPermitsExtension()
    {
        return $this->hasMany(\App\Models\WorkOrdersPermitsExtension::class,'work_orders_permit_id');
    }

    public function workOrdersPermitsFine()
    {
        return $this->hasMany(\App\Models\WorkOrdersPermitsFine::class,'work_orders_permit_id');
    }

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class , 'work_order_work_orders_permit' , 'work_orders_permit_id' , 'work_order_id');
    }

    public function restablishWorkOrders()
    {
        return $this->belongsToMany(WorkOrder::class , 'work_order_work_orders_permit' , 'work_orders_permit_id' , 'work_order_id')->where("current_department_id",4);
    }

    /**
     * Get the start_date
     *
     * @param  string  $value
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        return $value ;
    }

    /**
     * Get the end_date
     *
     * @param  string  $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return $value;
    }

    /**
     * Get the issue_date
     *
     * @param  string  $value
     * @return string
     */
    public function getIssueDateAttribute($value)
    {
        return $value;
    }

    /**
     * Get the total Permit Period.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function totalPermitPeriod(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if($attributes['issue_date']){
                    $dt1 = Carbon::now();
                    $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                    return $dt2->diffInDays($dt1);
                }
                return 0;

            }
        );
    }

    protected function totalPermitPeriodPercentage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if($attributes['issue_date']){
                    $totalPermitPeriodPercentage = 0;
                    $dt1 = Carbon::now();
                    $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                    $diff =$dt2->diffInDays($dt1);
                    if($attributes['period'] > 0){
                        $totalPermitPeriodPercentage = ($diff / $attributes['period'])*100;
                    }

                    return (int) $totalPermitPeriodPercentage ;
                }
                return 0;
            }
        );
    }

    protected function workPeriod(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if($attributes['issue_date']){
                    $dt1 = Carbon::now();
                    $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                    $diff =$dt2->diffInDays($dt1);

                    return (int) $diff ;
                }
                return 0;
            }
        );
    }


    protected function totalPermitPeriodDay(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if($attributes['issue_date']){
                    $dt1 = Carbon::now();
                $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                $diff = $dt2->diffInDays($dt1);
                if (!isset($attributes['period']) || $attributes['period'] < 0) {
                    return 0;
                }

                $remainingDays = $attributes['period'] - $diff;

                return max($remainingDays, 0);
            }
                return 0;
            }
        );
    }
}
