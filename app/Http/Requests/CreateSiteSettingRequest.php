<?php

namespace App\Http\Requests;

use App\Models\SiteSetting;
use Illuminate\Foundation\Http\FormRequest;

class CreateSiteSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return SiteSetting::$rules;
    }
}
