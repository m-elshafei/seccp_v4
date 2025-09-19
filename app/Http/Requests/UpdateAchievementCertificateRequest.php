<?php

namespace App\Http\Requests;

use App\Models\AchievementCertificate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAchievementCertificateRequest extends FormRequest
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
        $rules = AchievementCertificate::$rules;

        return $rules;
    }
}
