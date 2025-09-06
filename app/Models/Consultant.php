<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class Consultant
 * @package App\Models
 * @version January 2, 2023, 5:50 am UTC
 *
 * @property string $name
 */
class Consultant extends AppBaseModel
{
use LogsActivity;
    use SoftDeletes;


    public $table = 'consultants';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Consultant')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logAll();
    }

    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    



    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\Consultant']);
    }
}
