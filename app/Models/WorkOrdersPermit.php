<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\AppBaseModel;
use App\Http\Traits\AttachmentTrait;
use App\Models\WorkOrdersPermitsFine;
use App\Models\WorkOrdersPermitsExtension;
use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Helpers\Helper;
use App\Models\WorkOrdersPermitNote;
/**
 * Class WorkOrdersPermit
 * @package App\Models
 * @version February 10, 2022, 7:16 pm UTC
 *
 * @property string $permit_number
 * @property integer $work_orders_permit_type_id
 * @property integer $sadad_number
 * @property integer $total_extend_period
 * @property number $issued_amount
 * @property number $total_amount
 * @property number $total_extend_amount
 * @property number $total_fines_amount
 * @property integer $period
 * @property string $issue_date
 * @property string $start_date
 * @property string $end_date
 * @property string $notes
 * @property integer $status
 */
class WorkOrdersPermit extends AppBaseModel
{
    use SoftDeletes , AttachmentTrait , CreatedUpdatedBy , Branchable;


    public $table = 'work_orders_permits';




    protected $appends = ['total_work_period','total_permit_period','total_permit_period_percentage','status_title','total_permit_period_day'];


    public $fillable = [
        'permit_number',
        'work_orders_permit_type_id',
        'district_id',
        'balady_id',
        'street',
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
        'is_mission',
        'refuse_reason',

        'length_dust',
        'length_asphalt',
        'length_sidewalk',
        'length_total',
        'drilling_type',
        'drilling_deep',
        'drilling_layer',
        'drilling_width',
        'completion_certificate_status',
        'completion_certificate_date',
        'clearance_certificate_status',
        'clearance_certificate_date',

        'clearance_sdad_number',
        'clearance_sdad_date',
        'clearance_sdad_amount',
        'total_extend_period',
        'total_period',
        'restablish_convert_date'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'permit_number' => 'string',
        'work_orders_permit_type_id' => 'integer',
        'district_id' => 'integer',
        'balady_id' => 'integer',
        'street' => 'integer',
        'total_extend_period' => 'integer',
        'sadad_number' => 'integer',
        'issued_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'total_extend_amount' => 'decimal:2',
        'total_fines_amount' => 'decimal:2',
        'clearance_sdad_amount' => 'decimal:2',
        'period' => 'integer',
        'issue_date' => 'date',
        'start_date' => 'date',
        'clearance_sdad_date' => 'date',
        'end_date' => 'date',
        'status' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

        'is_mission'        => 'required|in:0,1',
        // 'permit_number'     => 'required_without:sadad_number|nullable|numeric',
        // 'sadad_number'      => 'required|numeric',
        'work_orders_permit_type_id' => 'required',
        'balady_id' => 'required',
        'issue_date'        => 'required_with:permit_number|date|nullable',
        'end_date'          => 'required_with:permit_number|date|nullable|after:issue_date',
        'work_order_id'     => 'required_if:is_mission,0',
        'mission_id'        => 'required_if:is_mission,1',
        'issued_amount'     => 'required|regex:/^\d+(\.\d{1,2})?$/'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules_update = [
        'permit_number'     => 'required_without:sadad_number|nullable|numeric',
        'sadad_number'      => 'required|numeric',
        'work_orders_permit_type_id' => 'required',
        'issue_date'        => 'required_with:permit_number|date|nullable',
        'end_date'          => 'required_with:permit_number|date|nullable|after:issue_date',
        'issued_amount'     => 'required|regex:/^\d+(\.\d{1,2})?$/'
    ];


    public function workOrdersPermitType()
    {
        return $this->belongsTo(\App\Models\WorkOrdersPermitType::class);
    }


    public function workOrdersPermitsExtension()
    {
        return $this->hasMany(\App\Models\WorkOrdersPermitsExtension::class);
    }

    public function user()
    {
        return $this->hasOne(\App\Models\User::class,'id','created_by');
    }

    public function workOrdersPermitsFine()
    {
        return $this->hasMany(\App\Models\WorkOrdersPermitsFine::class);
    }

    public function workOrders()
    {
        return $this->belongsToMany(WorkOrder::class);
    }

    public function landLayers()
    {
        return $this->hasMany(\App\Models\LandLayer::class , 'work_orders_permit_id' , 'id' );
    }

    public function employee()
    {
        return $this->hasMany(\App\Models\layer_employee_id::class , 'work_orders_permit_id' , 'id' );
    }

    public function contractor()
    {
        return $this->hasMany(\App\Models\layer_employee_id::class , 'layer_contractor_id' , 'id' );
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


    public function workOrdersPermitNote()
    {
        return $this->hasMany(WorkOrdersPermitNote::class,'permit_number','permit_number');
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

    public function getTotalPermitPeriodAttribute($value)
    {
        return $value;
    }

    protected function statusTitle(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
            return config("const.work_order_permit_status.".$attributes['status']);
            }
        );
    }

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */protected function totalWorkPeriod(): Attribute
{
    return Attribute::make(
        get: function ($value, $attributes) {
            $workOrder = WorkOrder::where('work_order_number', $attributes['work_order_number'])
                                   ->orWhere('mission_number', $attributes['work_order_number'])->first();
            if (!$workOrder || !$workOrder->received_date) {
                return 0;
            }
            $receivedDate = Carbon::parse($workOrder->received_date);
            if ($attributes['status'] > 3) {
                $transaction = WorkOrderTransactionsHistory::where('work_order_number', $workOrder->work_order_number)
                                                           ->where('new_status', $attributes['status'])->latest()->first();
                if ($transaction) {
                    $transactionDate = Carbon::parse($transaction->created_at);
                    return $receivedDate->diffInDays($transactionDate);
                }
            }
            return $receivedDate->diffInDays(Carbon::now());
        }
    );
}





    protected function totalPermitPeriodPercentage(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if($attributes['issue_date']  ){
                   $totalPermitPeriodPercentage = 0;
                    $dt1 = Carbon::now();
                    $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                    $diff =$dt2->diffInDays($dt1);
                    if($attributes['period'] > 0){
                    $totalPermitPeriodPercentage = ($diff / $attributes['period'])*100;
                    }
                    return (int) $totalPermitPeriodPercentage ;
                }
                return 0 ;

            }
        );
    }

    protected function totalPermitPeriodDay(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['issue_date']){
                    $dt1 = Carbon::now();
                    $dt2 = Carbon::createFromFormat('Y-m-d', $attributes['issue_date']);
                    $diff = $dt2->diffInDays($dt1);
                    if (!isset($attributes['period']) || $attributes['period'] < 0) {
                        return 0;
                    }
                    $remainingDays = $attributes['period'] - $diff;
                    return max($remainingDays, 0);
                }else{
                    return "-";
                }
            }
        );
    }



}






