<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class FinancialDueType
 * @package App\Models
 * @version May 15, 2022, 5:35 pm UTC
 *
 * @property string $name
 */
class FinancialDueType extends AppBaseModel
{
    use LogsActivity;
    use SoftDeletes;


    public $table = 'financial_due_types';
    

   




    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('FinancialDueType')
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
        return $this->hasMany(Activity::class,'subject_id','id')->where(['subject_type'=>'App\Models\FinancialDueType']);
    }
}
