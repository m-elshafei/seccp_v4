<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrderNote extends AppBaseModel
{
    use HasFactory;
    use Branchable;
    use LogsActivity;
    use CreatedUpdatedBy;

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
        'deleted_at'   =>'datetime'
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
