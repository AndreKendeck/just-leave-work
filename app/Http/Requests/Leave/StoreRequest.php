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
            'from' => ['date', 'required'],
            'until' => ['date', 'nullable'],
            'halfDay' => ['nullable', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'reason.exists' => ['Please select a valid resaon'],
            'reason.required' => ['Please select a reason for your leave'],
            'from.date' => ['Please enter a valid date'],
            'until.date' => ['Please enter a valid date'],
            'from.required' => ['Please enter your leave starting date'],
        ];
    }
}
