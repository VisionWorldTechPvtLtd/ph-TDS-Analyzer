<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Pumps extends FormRequest
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
            'pump_title' => 'required|string|min:3',
            'plan_id' => 'required',
            'user_id' => 'required',
            'serial_no' => 'required|string',
            'last_calibration_date' => 'required|string',
            'pipe_size' => 'required|string',
            'manufacturer' => 'required|string|min:3',
            'imei_no' => 'required|string',
            'mobile_no' => 'required|string',
            'sim_number' => 'nullable|exists:sims,id',
        ];
    }
}
