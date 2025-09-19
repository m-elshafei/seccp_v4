<?php

namespace App\Http\Requests;

use App\Models\WorkOrdersPermit;
use Illuminate\Foundation\Http\FormRequest;

class CreateWorkOrdersPermitRequest extends FormRequest
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
        return WorkOrdersPermit::$rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return string[]
     */
    public function messages()
    {
        return [
            'work_order_id.required_if' => 'حقل امر العمل مطلوب',
            'mission_id.required_if' => 'حقل المهمة مطلوب',
        ];
    }
}
