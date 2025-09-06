<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class WorkOrdersPermitType
 * @package App\Models
 * @version January 6, 2022, 11:04 am UTC
 *
 * @property string $name
 * @property string $description
 */
class WorkOrderEmergencyMissions extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'work_order_emergency_missions';
    

    protected $casts = [
        'deleted_at'   =>'datetime'
    ];



    public $fillable = [
        'work_order_id',
        'mission_received_employee',
        'mission_operation_number',
        'mission_meter_number',
        'electricity_employee_name',
        'mission_executed_worker_type',
        'mission_executed_employee_id',
        'mission_executed_contractor_id',
        'mission_complete_date',
        'emergency_issues_type_id',
        'branch_id',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function receivedEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class,'mission_received_employee');
    }
}
