<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;


use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lab
 * @package App\Models
 * @version March 25, 2022, 1:41 pm UTC
 *
 * @property string $name
 */
class Lab extends AppBaseModel
{
    use LogsActivity;
    use SoftDeletes;
    use Branchable;


    public $table = 'labs';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Lab')
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
        'name' => 'required'
    ];

    



    public function activities(){
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\Lab']);
    }
}
