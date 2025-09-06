<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
class SiteSetting extends Model
{
     use SoftDeletes;    public $table = 'site_settings';

    public $fillable = [
        'site_name_en',
        'site_name_ar',
        'logo_path',
        'company_name',
        'big_photo',
        'site_alias',
        'site_main_color',
        'site_font_name',
        'message_home_page'
    ];

    protected $casts = [

    ];

    public static array $rules = [
        
    ];

    
}
