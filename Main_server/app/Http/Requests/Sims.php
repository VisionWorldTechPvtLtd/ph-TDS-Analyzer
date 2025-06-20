<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Sims extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this to true to allow the request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'sim_company' => 'required|string|min:3',
            'sim_imei' => 'required|unique:sims,sim_imei',
            'sim_number' => 'required|unique:sims,sim_number',
            'sim_name' => 'required|string',
            // 'sim_type' => 'required|boolean',
            'sim_type' => 'required|in:0,1,2',
            'sim_active' => 'required|boolean',
            'sim_purchase' => 'required|string',
            'sim_start' => 'required|string|min:3',
            'sim_end' => 'required|string',

        ];
    }
}
