<?php

namespace App\Http\Requests\Leave;


use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdjustmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermission('can-adjust-leave', auth()->user()->team);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => ['required', 'numeric', Rule::exists('users', 'id')
                ->where('team_id', auth()->user()->team_id)],
            'amount' => ['required', 'numeric', 'min:0']
        ];
    }
}
