<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermission('add-user', auth()->user()->organization);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required' , 'string' , 'min:3' ],
            'email' => ['required' , Rule::unique('users', 'email') , 'e-mail' ],
            'permissions' => ['nullable' , 'array' , 'min:1' ],
            'permissions.*.id' => ['required' , Rule::exists('permissions', 'id') ]
        ];
    }
}
