<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabResult extends AppBaseModel
{
    use HasFactory;
    use SoftDeletes;
    use Branchable;
    use CreatedUpdatedBy;

   
    
    public $fillable = [
        'lab_id',
        'land_layer_id',
        'lab_send_date',
        'lab_result_date',
        'lab_result_status'
    ];

      /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'lab_send_date' => 'date:Y-m-d',
        'lab_result_date' => 'date:Y-m-d',
        'lab_result_status' => 'integer',
        'deleted_at'   =>'datetime'
    ];
}
