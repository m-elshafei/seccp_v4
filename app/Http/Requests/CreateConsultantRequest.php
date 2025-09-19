<?php

namespace App\Http\Requests;

use App\Models\Consultant;
use Illuminate\Foundation\Http\FormRequest;

class CreateConsultantRequest extends FormRequest
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
        return Consultant::$rules;
    }
}
