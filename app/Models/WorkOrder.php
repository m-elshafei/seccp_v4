<?php

namespace App\Models;

use App\Traits\CurrentOwner;
use Carbon\Carbon;
use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Models\WorkOrderNote;
use App\Models\Employee;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use App\Models\WorkOrdersPermitNote;
use App\Http\Traits\AttachmentTrait;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\WorkOrderPermitStatusEnum;

/**
 * Class WorkOrder
 * @package App\Models
 * @version January 14, 2022, 9:52 pm UTC
 *
 * @property \App\Models\WorkType $workType
 * @property \App\Models\WorkOrdersType $workOrdersType
 * @property \App\Models\Branch $branch
 * @property \App\Models\City $city
 * @property \App\Models\District $district
 * @property \App\Models\Department $currentDepartment
 * @property \App\Models\ElectricalStationsType $electricalStationsType
 * @property \App\Models\WorkOrdersStage $workOrdersStage
 * @property \App\Models\ElectricityDepartment $electricityDepartment
 * @property string $work_order_number
 * @property string $reference_number
 * @property string $received_date
 * @property integer $work_type_id
 * @property integer $branch_id
 * @property integer $city_id
 * @property integer $district_id
 * @property string $x_axis
 * @property string $y_axis
 * @property string $street_name
 * @property string $customer_number
 * @property string $customer_name
 * @property string $electrical_station_number
 * @property integer $electrical_stations_type_id
 * @property integer $work_period
 * @property integer $status
 * @property integer $work_orders_stage_id
 * @property integer $electricity_department_id
 * @property integer $current_department_id
 * @property boolean $needs_drilling_operations
 * @property boolean $needs_electrical_work
 * @property boolean $needs_work_orders_permit
 * @property boolean $needs_program
 * @property string $finished_date
 * @property boolean $has_asbuilt
 * @property string $asbuilt_number
 * @property integer $achievement_certificate_id
 * @property integer $payment_clearance_id
 * @property integer $electricity_company_employee_id
 * @property integer $work_orders_type_id
 */
class WorkOrder extends AppBaseModel
{
    use SoftDeletes;
    use Branchable;
    use AttachmentTrait;
    use LogsActivity;
    use CreatedUpdatedBy;
    use CurrentOwner;


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('WorkOrder')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }


    public $table = 'work_orders';


    protected $dates = [
        'received_date',

    ];


    public $fillable = [
        'work_order_number',
        'reference_number',
        'received_date',
        'work_type_id',
        'branch_id',
        'city_id',
        'district_id',
        'x_axis',
        'y_axis',
        'street_name',
        'customer_number',
        'customer_name',
        'customer_mobile_number',
        'electrical_station_number',
        'electrical_stations_type_id',
        'work_period',
        'status',
        'work_orders_stage_id',
        'electricity_department_id',
        'current_department_id',
        'owner_department_id',
        'needs_drilling_operations',
        'needs_electrical_work',
        'needs_work_orders_permit',
        'needs_program',
        'drilling_status',
        'electrical_operations_status',
        'assay_forms_status',
        'gis_status',
        'finished_date',
        'stop_date',
        'stop_note',
        'has_asbuilt',
        'asbuilt_number',
        'asbuilt_status',
        'achievement_certificate_id',
        'payment_clearance_id',
        'work_orders_type_id',
        'parent_id',
        'project_id',
        'project_stage_id',

        'mission_number',
        //'mission_received_employee',
        'mission_typeـid',
        'is_emergency_mission',
        'mission_opreation_number',
        //'mission_meter_number',
        //'shift_number',
        //'electricity_employee_name',
        'description',
        'consultant_id',
        'electricity_company_employee_id',
        'source_name',
        'purchase_number',
        'invoice_amount',
        'material_reservation_number',
        'electrical_station_number_2',
        'reservation',
        'is_assay_form'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_order_number' => 'string',
        'reference_number' => 'string',
        'received_date' => 'datetime:Y-m-d',
        'work_type_id' => 'integer',
        'branch_id' => 'integer',
        'city_id' => 'integer',
        'district_id' => 'integer',
        'x_axis' => 'string',
        'y_axis' => 'string',
        'street_name' => 'string',
        'customer_number' => 'string',
        'customer_name' => 'string',
        'electrical_station_number' => 'string',
        'electrical_stations_type_id' => 'integer',
        'work_period' => 'integer',
        'status' => 'integer',
        'work_orders_stage_id' => 'integer',
        'electricity_department_id' => 'integer',
        'current_department_id' => 'integer',
        'needs_drilling_operations' => 'boolean',
        'needs_electrical_work' => 'boolean',
        'needs_work_orders_permit' => 'boolean',
        'needs_program' => 'boolean',
        'finished_date' => 'date',
        'has_asbuilt' => 'boolean',
        'asbuilt_number' => 'string',
        'achievement_certificate_id' => 'integer',
        'parent_id' => 'integer',
        'payment_clearance_id' => 'integer',
        'work_orders_type_id' => 'integer',
        'created_at' => 'date:Y-m-d',
        'last_action_date_time' => 'date:Y-m-d',
        'deleted_at'   =>'datetime',
        'electricity_company_employee_id'   =>'integer',
    ];

    protected $appends = ['work_display_number','total_work_period' , 'work_dispaly_number_permit','status_title', 'layer1' , 'layer2' , 'layer3' , 'layer4' , 'layer5' , 'layer6'];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'work_order_number' => 'required',
        'received_date' => 'required',
        'work_type_id' => 'required|numeric|gt:0',
        // 'branch_id' => 'required',
        // 'city_id' => 'required',
        'consultant_id' => 'required',
        'district_id' => 'required'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules_update = [
        'district_id' => 'required'
    ];

    //  /**
    //  * Scope a query to only include popular users.
    //  *
    //  * @param  \Illuminate\Database\Eloquent\Builder  $query
    //  * @return \Illuminate\Database\Eloquent\Builder
    //  */
    // public function scopePopular($query)
    // {
    //     return $query->where('votes', '>', 100);
    // }

    /************************************ */
    public function getDrillingWorkOrders()
    {
        return $this->where('is_emergency_mission',0)->where("status","<>",1)->where("current_department_id",1)->whereNull('project_id');

        // return $this->where('is_emergency_mission', 0)
        // ->where('current_department_id', '<', 6)
        // ->where('current_department_id', '<>', 1)
        // ->whereNull('project_id');
        // ->whereIn("status" , [
        //     WorkOrderPermitStatusEnum::PaidAndIssued , // [3,4,5,6,7] تم السداد والاصدار  -- تم تسليم التصريح
        //     WorkOrderPermitStatusEnum::UnderWay ,
        //     WorkOrderPermitStatusEnum::UnderDelivery,
        //     WorkOrderPermitStatusEnum:: InitialDelivery,
        //     WorkOrderPermitStatusEnum:: FinalDelivery,
        //     WorkOrderPermitStatusEnum::WaitingForProcess,
        //     ]);
    }

    // public function getFinishedDrillingWorkOrders()
    // {
    //     return $this->where('drilling_status',2)->where('is_emergency_mission',0)->where("status","<>",1)->where("owner_department_id",1)->whereNull('project_id');
    // }

    public function getFinishedDrillingWorkOrders()
    {
        return $this->where('drilling_status',2)->where('is_emergency_mission',0)->where("status","<>",1)->where("owner_department_id",1);
    }

    public function getDrillingProjectWorkOrders()
    {
        return $this->where('is_emergency_mission',0)->where("status","<>",1)->where("current_department_id",1)->whereNotNull('project_id');
    }

    public function getElectricWorkOrders()
    {
        return $this->newQuery()->where('is_emergency_mission',0)->where("status","<>",1)->where("needs_electrical_work",1)->whereIn("current_department_id",[1,2]);
    }

    public function getElectricTowersWorkOrders()
    {
        return $this->newQuery()->where('is_emergency_mission',0)->where("status","<>",1)->where("current_department_id",3);
    }
    public function getEmergencyWorkOrdersWorkOrderOnly()
    {
        return $this->where('is_emergency_mission',0);
    }
    /************************************ */

    /*********** Start Relations ************************* */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\WorkOrder']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function workType()
    {
        return $this->belongsTo(\App\Models\WorkType::class);
    }

    public function electricity_company_employees()
    {
        return $this->belongsTo(\App\Models\ElectricityCompanyEmployees::class,'electricity_company_employee_id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function workOrdersType()
    {
        return $this->belongsTo(\App\Models\WorkOrdersType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }

    /***
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function achievementCertificate(){
        return $this->hasMany(AchievementCertificate::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
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
    public function consultant()
    {
        return $this->belongsTo(\App\Models\Consultant::class);
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

    public function departmentEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'owner_department_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function meters()
    {
        return $this->hasMany(\App\Models\ElectricMeter::class, 'work_order_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function electricalStationsType()
    {
        return $this->belongsTo(\App\Models\ElectricalStationsType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function workOrdersStage()
    {
        return $this->belongsTo(\App\Models\WorkOrdersStage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function assay_forms()
    {
        return $this->hasMany(\App\Models\AssayForm::class,'work_order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function electricityDepartment()
    {
        return $this->belongsTo(\App\Models\ElectricityDepartment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function workOrdersPermits()
    {
        return $this->belongsToMany(WorkOrdersPermit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function financialDue()
    {
        return $this->belongsToMany(FinancialDue::class,'work_order_financial_due');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function landLayers()
    {
        return $this->hasMany(\App\Models\LandLayer::class , 'work_order_id' , 'id' );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     **/
    public function workOrdersNotes()
    {
        return $this->hasMany(WorkOrderNote::class);
    }

    public function workOrdersPermitNote()
    {
        return $this->hasMany(WorkOrdersPermitNote::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function landscape()
    {
        return $this->hasOne(LandscapeInformation::class, 'work_order_id' , 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function electrical_operation()
    {
        return $this->hasOne(ElectricalOperation::class, 'work_order_id' , 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     **/
    public function electricity_tower()
    {
        return $this->hasOne(ElectricityTower::class, 'work_order_id' , 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function project()
    {
        return $this->belongsTo(WorkOrdersProject::class, 'project_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function parent()
    {
        return $this->belongsTo(WorkOrder::class, 'parent_id' , 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'parent_id' , 'id');
    }

    public function emergencyMissionType()
    {
        return $this->hasOne(MissionType::class,'id','mission_typeـid');
    }

    /* Attributes  */


    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function totalWorkPeriod(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value, $attributes) {
    //             $transaction = WorkOrderTransactionsHistory::where('work_order_number', $attributes['work_order_number'])
    //                                                         ->where('new_status', $attributes['status'])->latest()->first();
    //             $dt1 = ($attributes['status'] > 3) ? $transaction['created_at'] : Carbon::now();
    //             $dt2 = Carbon::parse($attributes['received_date']);
    //             return $dt2->diffInDays($dt1);
    //         }
    //     );
    // }

    protected function totalWorkPeriod(): Attribute
{
    return Attribute::make(
        get: function ($value, $attributes) {
            if (!isset($attributes['work_order_number']) || !isset($attributes['status'])) {
                return 0;
            }

            $transaction = WorkOrderTransactionsHistory::where('work_order_number', $attributes['work_order_number'])
                                                        ->where('new_status', $attributes['status'])->latest()->first();

            $dt1 = ($attributes['status'] > 3 && $transaction) ? $transaction->created_at : Carbon::now();

            $dt2 = isset($attributes['received_date']) ? Carbon::parse($attributes['received_date']) : Carbon::now();

            return $dt2->diffInDays($dt1);
        }
    );
}


    protected function statusTitle(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
            return config("const.work_order_general_status.".$attributes['status']);
            }
        );
    }

    protected function getWorkDisplayNumberAttribute()
    {
        if($this->attributes['work_order_number']){
            return $this->attributes['work_order_number'].' / '.$this->workType->full_name;
        }else{
            return $this->attributes['mission_number'].' / ( مهمة طوارئ ) ';
        }
    }

    public function workDispalyNumberPermit(): Attribute
    {
        return new Attribute(
            get: function(){
                if($this->attributes['work_order_number']){
                    return $this->attributes['work_order_number'].' / '.$this->workType->full_name_to_permit;
                }else{
                    if ($this->attributes['reference_number']) {
                        return $this->attributes['mission_number'] .' / ( مهمة طوارئ ) - '.$this->attributes['reference_number'] ;
                    }else{

                        return $this->attributes['mission_number'] .' / ( مهمة طوارئ ) ' ;
                    }
                }
                // return  $this->attributes['work_order_number'].' / '.$this->workType->full_name_to_permit ;
            }
        );
    }

    public function getLayer1Attribute()
    {
        return $this->landLayers->where('layer_id',1)->first();
    }

    public function getLayer2Attribute()
    {
        return $this->landLayers->where('layer_id',2)->first();
    }

    public function getLayer3Attribute()
    {
        return $this->landLayers->where('layer_id',3)->first();
    }

    public function getLayer4Attribute()
    {
        return $this->landLayers->where('layer_id',4)->first();
    }

    public function getLayer5Attribute()
    {
        return $this->landLayers->where('layer_id',5)->first();
    }

    public function getLayer6Attribute()
    {
        return $this->landLayers->where('layer_id',6)->first();
    }
}
