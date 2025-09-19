<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WorkOrdersType
 *
 * @version January 6, 2022, 11:42 am UTC
 *
 * @property string $name
 * @property int $parent_id
 */
class WorkOrdersType extends AppBaseModel
{
    use SoftDeletes;

    public $table = 'work_orders_types';

    public $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'parent_id' => 'integer',
        'deleted_at' => 'datetime',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];
}
