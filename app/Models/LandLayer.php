<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LandLayer extends AppBaseModel
{
    use Branchable;
    use CreatedUpdatedBy;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    public $fillable = [
        'name',
        'start_date',
        'end_date',
        'lab_send_date',
        'lab_id',
        'lab_result_status',
        'layer_status',
        'layer_worker_type',
        'work_order_id',
        'layer_id',
        'note',
        'layer_employee_id',
        'layer_contractor_id',
        'work_orders_permit_id',
        'description',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'lab_send_date' => 'date:Y-m-d',
        'work_order_id' => 'integer',
        'layer_status' => 'integer',
        'deleted_at' => 'datetime',
        // 'lab_result_status' => 'integer'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('LandLayer')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function getStartDateAttribute($value)
    {
        return $value;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'layer_employee_id', 'id')->withDefault();
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'layer_contractor_id', 'id')->withDefault();
    }
}
