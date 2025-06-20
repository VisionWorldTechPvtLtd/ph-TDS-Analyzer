<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class STPRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:3',
            'plan_id' => 'required',
            'user_id' => 'required',
            'serial_no' => 'required|string',
            'manufacturer' => 'required|string|min:3',
            'imei_no' => 'required|string',
            'mobile_no' => 'required|string',
            'user_key' => 'required|string'
        ];
    }
}
