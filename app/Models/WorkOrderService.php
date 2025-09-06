<?php

namespace App\Models;


use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class WorkOrderService
 * @package App\Models
 * @version March 5, 2022, 2:22 pm UTC
 *
 * @property \App\Models\Unit $unit
 * @property \App\Models\ServicesCategory $servicesCategory
 * @property string $name
 * @property string $name_ar
 * @property string $code
 * @property number $price
 * @property string $description
 * @property integer $unit_id
 * @property integer $services_category_id
 */
class WorkOrderService extends AppBaseModel
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('WorkOrderService')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['name', 'username', 'email']);
    }


    public $table = 'work_order_services';






    public $fillable = [
        'name',
        'name_ar',
        'code',
        'price',
        'description',
        'unit_id',
        'services_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'name_ar' => 'string',
        'code' => 'string',
        'price' => 'double',
        'description' => 'string',
        'unit_id' => 'integer',
        'services_category_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'name_ar' => 'required',
        'price' => 'required',
        'code' => 'required',
        'unit_id' => 'required',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     **/
    public function servicesCategory()
    {
        return $this->belongsTo(ServicesCategory::class, 'services_category_id', 'id')->withDefault();
    }
}
