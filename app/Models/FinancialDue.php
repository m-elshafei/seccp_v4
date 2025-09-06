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
 * Class FinancialDue
 * @package App\Models
 * @version May 21, 2022, 7:11 pm UTC
 *
 * @property string $due_no
 * @property string $due_date
 * @property integer $status
 * @property integer $financial_due_type_id
 * @property integer $electricity_department_id
 * @property number $total_amount
 * @property number $total_fines_amount
 * @property number $total_net_amount
 * @property string $notes
 */
class FinancialDue extends AppBaseModel
{
    use LogsActivity;
    use SoftDeletes;
    use Branchable;
    use CreatedUpdatedBy;



    public $table = 'financial_dues';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('FinancialDue')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $fillable = [
        'due_no',
        'due_date',
        'status',
        'financial_due_type_id',
        'electricity_department_id',
        'total_amount',
        'total_fines_amount',
        'total_net_amount',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'due_no' => 'string',
        'due_date' => 'date:Y-m-d',
        'status' => 'integer',
        'financial_due_type_id' => 'integer',
        'electricity_department_id' => 'integer',
        'total_amount' => 'decimal:2',
        'total_fines_amount' => 'decimal:2',
        'total_net_amount' => 'decimal:2',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'due_no' => 'required',
        'financial_due_type_id' => 'required|numeric',
        'electricity_department_id' => 'required|numeric',
        'due_date' => 'required|date',
        'total_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'total_fines_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
        'total_net_amount' => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
    ];


    public function financialDueType()
    {
        return $this->belongsTo(FinancialDueType::class);
    }
    
    public function electricityDepartment()
    {
        return $this->belongsTo(ElectricityDepartment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     **/
    public function workOrder()
    {
        return $this->belongsToMany(WorkOrder::class,'work_order_financial_due');
    }



    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\FinancialDue']);
    }
}
