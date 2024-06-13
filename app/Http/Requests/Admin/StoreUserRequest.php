<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,user'],
        ];
    }
}
