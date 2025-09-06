<?php

namespace App\Models;

use App\Traits\Branchable;
use App\Models\AppBaseModel;
use App\Http\Traits\AttachmentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Contractor
 * @package App\Models
 * @version January 6, 2022, 12:13 pm UTC
 *
 * @property string $name
 * @property string $company_name
 * @property string $contact_name
 * @property string $contact_mobile_number
 * @property string $notes
 */
class Contractor extends AppBaseModel
{
    use SoftDeletes;
    use AttachmentTrait;
    use Branchable;

    public $table = 'contractors';
    

   



    public $fillable = [
        'name',
        'company_name',
        'contact_name',
        'contact_mobile_number',
        'notes'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'company_name' => 'string',
        'contact_name' => 'string',
        'contact_mobile_number' => 'string',
        'notes' => 'string',
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

    protected function getDisplayNameAttribute()
    {
        return $this->attributes['id'].' / '.$this->attributes['name'];
    }

    
}
