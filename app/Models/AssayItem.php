<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class AssayItem
 *
 * @version March 15, 2022, 2:33 pm UTC
 *
 * @property int $assay_form_id
 * @property int $item_id
 * @property int $spend
 * @property int $used
 * @property int $returned
 */
class AssayItem extends AppBaseModel
{
    use Branchable, CreatedUpdatedBy, LogsActivity , SoftDeletes;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('AssayItem')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $table = 'assay_items';

    public $fillable = [
        'assay_form_id',
        'item_id',
        'spend',
        'used',
        'returned',
        'returned_spend',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'assay_form_id' => 'integer',
        'item_id' => 'integer',
        'spend' => 'integer',
        'used' => 'integer',
        'returned' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'assay_form_id' => 'required',
        'item_id' => 'required|exists:items,id',
        'spend' => 'required|integer|gte:0',
        'used' => 'required|integer',
        // 'returned'      => 'nullable|integer|lte:spend'
    ];

    protected $appends = [
        // 'remaining',
        'item_name',
        'item_code',
    ];

    public function getRemainingAttribute()
    {
        return $this->attributes['spend'] - $this->attributes['used'];
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'subject_id', 'id')->where(['subject_type' => 'App\Models\AssayItem']);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id')->withDefault();
    }

    public function getItemNameAttribute()
    {
        $row = $this->belongsTo(Item::class, 'item_id', 'id')->first();
        if ($row) {
            return $row->name ?? '';
        }

        return '';
    }

    public function getItemCodeAttribute()
    {
        $row = $this->belongsTo(Item::class, 'item_id', 'id')->first();
        if ($row) {
            return $row->code ?? '';
        }

        return '';
    }
}
