<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class STPReportRequest extends FormRequest
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
            'stp_id' => 'required|array',
            'stp_id.*' => 'integer|exists:s_t_p_s,id',
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ];
    }
}
