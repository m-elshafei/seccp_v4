<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabResult extends AppBaseModel
{
    use Branchable;
    use CreatedUpdatedBy;
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'lab_id',
        'land_layer_id',
        'lab_send_date',
        'lab_result_date',
        'lab_result_status',
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
        'deleted_at' => 'datetime',
    ];
}
