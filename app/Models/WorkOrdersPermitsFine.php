<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use App\Enums\WorkOrderPermitStatusEnum;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrdersPermitsFine extends AppBaseModel
{
    use HasFactory , SoftDeletes, Branchable , CreatedUpdatedBy;




    public $fillable = [
        'work_orders_permit_id',
        'issue_date',
        'sadad_number',
        'amount',
        'status',
        'fine_reason',
        'notes',
        'total_fines_amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_orders_permit_id' => 'integer',
        'issue_date' => 'date:Y-m-d',
        'sadad_number' => 'integer',
        'amount' => 'decimal:2',
        'status' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'work_orders_permit_id' => 'required',
        'amount' => 'required',
        'issue_date' => 'required',
    ];

    public function workOrdersPermits()
    {
        return $this->hasOne(\App\Models\WorkOrdersPermit::class,'id','work_orders_permit_id');
    }
    public function getRestablishWorkOrders()
    {
        return $this->orderBy('work_orders_permit_id', 'DESC');;
    }
}
