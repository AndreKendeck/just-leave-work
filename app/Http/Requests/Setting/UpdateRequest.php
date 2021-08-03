<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('team-admin', auth()->user()->team);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leave_added_per_cycle' => ['required', 'integer', 'min:0'],
            'days_until_balance_added' => ['required', 'integer', 'min:0'],
            'excluded_days' => ['nullable', 'array']
        ];
    }

    /**
     * Custom validation messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'days_until_balance_added.required' => 'Please specify if you want automatic leave approvals',
            'leave_added_per_cycle.required' => 'Please specify the amount of leave you want added per cycle',
        ];
    }
}
