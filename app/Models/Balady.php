<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Balady
 * @package App\Models
 * @version May 30, 2022, 3:54 pm UTC
 *
 * @property string $name
 * @property integer $city_id
 */
class Balady extends AppBaseModel
{
use LogsActivity;
    use SoftDeletes;


    public $table = 'baladies';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Balady')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $fillable = [
        'name',
        'city_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'city_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'   
    ];

    
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }


    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\Balady']);
    }
}
