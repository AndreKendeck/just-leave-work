<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'team_name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'unique:users,email', 'email'],
            'name' => ['required', 'string', 'min:2'], 
            'password' => ['required' , 'string' , 'min:6' ]
        ];
    }
}
