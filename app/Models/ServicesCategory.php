<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


/**
 * Class ServicesCategory
 * @package App\Models
 * @version March 5, 2022, 2:18 pm UTC
 *
 * @property string $name
 * @property string $name_ar
 */
class ServicesCategory extends AppBaseModel
{
    use SoftDeletes, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('ServicesCategory')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logOnly(['name', 'username', 'email']);
    }


    public $table = 'services_categories';
    

   



    public $fillable = [
        'name',
        'name_ar'
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
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function WorkOrderService(){
        return $this->hasMany(ServicesCategory::class,'services_category_id', 'id');
    }
    
}
