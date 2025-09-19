<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkOrderNote extends AppBaseModel
{
    use Branchable;
    use CreatedUpdatedBy;
    use HasFactory;
    use LogsActivity;
    use SoftDeletes;

    public $table = 'work_order_notes';

    public $fillable = [
        'work_order_number',
        'work_order_id',
        'note',
        'work_order_status',
        'user_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'work_order_number' => 'string',
        'work_order_id' => 'integer',
        'note' => 'string',
        'work_order_status' => 'integer',
        'user_id' => 'integer',
        'deleted_at' => 'datetime',
    ];

    public static $rules = [
        'note' => 'required',
        'work_order_id' => 'required',
        'user_id' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('WorkOrderNote')
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
