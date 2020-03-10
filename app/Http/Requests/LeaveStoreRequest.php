<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'organization_id' => ['required' , Rule::exists('organizations' , 'id') ],
            'reason_id' => [ 'required' , Rule::exists('reasons' , 'id') ],
            'description' => ['required' , 'string' , 'min:3' ],
            'from' => ['required' , 'date' , 'after_or_equal:today' ],
            'until' => ['required' , 'date' , 'after_or_equal:today' ],
        ];
    }

    public function messages()
    {
        return  [
            'reason.required' => 'Please select a reason',  
            'from.required' => 'Please select a day which you would like to take leave from',
            'until.required' => 'Please select a day which you would like to return back from your leave',
            'from.after_or_equal' => 'Please select a date from today or anytime in the future', 
            'until.after_or_equal' => 'Please select a date from today or anytime in the future'
       ];
    }
}
