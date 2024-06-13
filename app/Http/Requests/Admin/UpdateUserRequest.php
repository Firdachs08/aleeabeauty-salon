<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'username' => ['required', Rule::unique('users')->ignore($this->user)],
            'email' => ['required', Rule::unique('users')->ignore($this->user)],
            'phone' => ['required', Rule::unique('users')->ignore($this->user)],
            'password' => ['nullable'],
            'role' => ['required', 'in:admin,user'],
        ];
    }
}
