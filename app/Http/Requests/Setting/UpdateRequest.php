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
            'automatic_leave_approval' => ['required', 'boolean'],
            'leave_added_per_cycle' => ['required', 'integer', 'min:0'],
            'maximum_leave_days' => ['required', 'integer', 'min:1'],
            'maximum_leave_balance' => ['required', 'integer', 'min:0'],
            'days_until_balance_added' => ['required', 'integer', 'min:0'],
            'can_approve_own_leave' => ['required', 'boolean'],
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
            'automatic_leave_approval.required' => 'Please specify if you want automatic leave approvals',
            'leave_added_per_cycle' => 'Please specify the amount of leave you want added per cycle',
        ];
    }
}
