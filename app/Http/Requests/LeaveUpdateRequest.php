<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeaveUpdateRequest extends FormRequest
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
            'reason_id' => [ 'required' , Rule::exists('reasons' , 'id') ],
            'description' => ['required' , 'string' , 'min:3' ],
        ];
    }

    public function messages()
    {
        return  [
            'reason_id.required' => 'Please select a reason',
       ];
    }
}
