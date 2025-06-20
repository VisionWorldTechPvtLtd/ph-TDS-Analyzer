<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class dailystpreport extends FormRequest
{
    public function authorize()
    {
        return true;
    }

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
