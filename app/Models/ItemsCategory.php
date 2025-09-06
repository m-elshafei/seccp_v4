<?php

namespace App\Models;


use App\Models\AppBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ItemsCategory
 * @package App\Models
 * @version January 14, 2022, 6:36 pm UTC
 *
 * @property string $name
 * @property integer $name_ar
 * @property integer $parent_id
 */
class ItemsCategory extends AppBaseModel
{
    use SoftDeletes;


    public $table = 'items_categories';
    

   



    public $fillable = [
        'name',
        'name_ar',
        'parent_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'name_ar' => 'string',
        'parent_id' => 'integer',
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
    public function category()
    {
        return $this->belongsTo(\App\Models\ItemsCategory::class,'parent_id','id')->withDefault([
            'name'=>''
        ]);
    }

    
}
