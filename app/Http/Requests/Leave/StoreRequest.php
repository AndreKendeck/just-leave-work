<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason' => ['required', 'exists:reasons,id'],
            'description' => ['required', 'min:3', 'string'],
            'from' => ['date', 'required'],
            'until' => ['date', 'nullable'],
            'half_day' => ['nullable', 'boolean'],
            'notifyUser' => [
                'nullable',
                Rule::exists('users', 'id')->where('team_id', auth()->user()->team_id),
            ],
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => ['Please select a reason for your leave'],
            'from.date' => ['Please enter a valid date'],
            'until.date' => ['Please enter a valid date'],
            'from.required' => ['Please enter your leave starting date'],
            'notifyUser.exists' => ['Please select a valid user to notify'],
        ];
    }
}
