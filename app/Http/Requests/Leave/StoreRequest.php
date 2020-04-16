<?php

namespace App\Http\Requests\Leave;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason_id' => ['required' , 'exists:reasons,id' ],
            'description' => ['required' , 'min:1' , 'string' ],
            'from' => ['required' , 'after_or_equal:today' , 'date' ],
            'until' => ['required' , "after_or_equal:today" , 'date' ],
            'reporter_id' => ['required' , Rule::exists('users', 'id')->where('team_id', auth()->user()->team_id) ]
        ];
    }

    public function messages()
    {
        return [
            'reason_id.required' => 'Please select a reason'
        ];
    }
}
