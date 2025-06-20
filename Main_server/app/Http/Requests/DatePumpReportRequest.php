<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatePumpReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Allow all users to make this request
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
        'pump_id' => 'required|integer|exists:pumps,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'year' => 'required|integer|min:' . (date('Y') - 5) . '|max:' . date('Y'),
    ];
}

}
