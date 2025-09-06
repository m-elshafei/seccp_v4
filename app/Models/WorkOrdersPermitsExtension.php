<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkOrdersPermitsExtension extends AppBaseModel
{
    
    use SoftDeletes , CreatedUpdatedBy , Branchable;


   


    public $fillable = [
        'work_orders_permit_id',
        'issue_date',
        'from_date',
        'to_date',
        'sadad_number',
        'amount',
        'status',
        'notes',
        'period',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'work_orders_permit_id' => 'integer',
        'issue_date' => 'date:Y-m-d',
        'from_date' => 'date:Y-m-d',
        'to_date' => 'date:Y-m-d',
        'sadad_number' => 'integer',
        'amount' => 'decimal:2',
        'status' => 'integer',
        'deleted_at'   =>'datetime'
    ];
    
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'work_orders_permit_id' => 'required',
        'amount' => 'required',
        'sadad_number' => 'numeric',
        // 'issue_date' => 'required',
        // 'from_date' => 'required',
        // 'to_date' => 'required'
    ];


  /**
     * Get the start_date
     *
     * @param  string  $value
     * @return string
     */
    public function getFromDateAttribute($value)
    {
        return $value ;
    }

    /**
     * Get the end_date
     *
     * @param  string  $value
     * @return string
     */
    public function getToDateAttribute($value)
    {
        return $value;
    }

    /**
     * Get the issue_date
     *
     * @param  string  $value
     * @return string
     */
    public function getIssueDateAttribute($value)
    {
        return $value;
    }


}
