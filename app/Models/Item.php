<?php

namespace App\Models;

use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Item
 * @package App\Models
 * @version January 14, 2022, 7:36 pm UTC
 *
 * @property \App\Models\ItemsCategory $itemsCategory
 * @property \App\Models\Unit $unit
 * @property string $code
 * @property string $name
 * @property string $name_ar
 * @property string $description
 * @property integer $unit_id
 * @property integer $items_category_id
 */
class Item extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'items';
    

   



    public $fillable = [
        'code',
        'name',
        'name_ar',
        'description',
        'unit_id',
        'items_category_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'code' => 'string',
        'name' => 'string',
        'name_ar' => 'string',
        'description' => 'string',
        'unit_id' => 'integer',
        'items_category_id' => 'integer',
        'deleted_at'   =>'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'name' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function category()
    {
        return $this->belongsTo(\App\Models\ItemsCategory::class,'items_category_id','id')->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class,'unit_id','id')->withDefault();
    }
}
