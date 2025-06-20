<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NegativeReportData extends FormRequest
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
            'month' => 'required|date_format:Y-m',
        ];
    }

    /**
     * Customize error messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'month.required' => 'The month field is required.',
            'month.date_format' => 'The month format must be YYYY-MM.',
        ];
    }
}
