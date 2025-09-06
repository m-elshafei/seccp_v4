<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrdersPermitNote extends AppBaseModel
{
    use HasFactory;
    use Branchable;
    use LogsActivity;
    use CreatedUpdatedBy;

    use SoftDeletes;


    public $table = 'work_order_permits_notes';




    public $fillable = [
        'permit_number',
        'note',
        'work_orders_permits_status',
        'work_orders_permits_id',
        'user_id',
        'work_order_id',
        'branch_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'permit_number' => 'string',
        'work_order_id' => 'integer',
        'note' => 'string',
        'work_orders_permits_status' => 'integer',
        'user_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    public static $rules = [
        'note' => 'required',
        'work_orders_permits_id' => 'required',
        'user_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('WorkOrdersPermitNote')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
