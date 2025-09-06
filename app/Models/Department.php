<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Department
 * @package App\Models
 * @version January 3, 2022, 12:15 am UTC
 *
 * @property \App\Models\Branch $branch
 * @property string $name
 * @property integer $branch_id
 * @property string $description
 */
class Department extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'departments';
    

   



    public $fillable = [
        'name',
        'branch_id',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'branch_id' => 'integer',
        'description' => 'string',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
}
