<?php

namespace App\Http\Requests;


class CreateUserRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return  [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:30|min:6',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => "name is required",
            'email.required' => "email is required",
            'email.unique' => "sorry this email is already registered",
            'password.required' => "password is required",
            // "password.min:6" => "The password must be at least 6 characters",
            // 'password.max:30' => "password can't be longer than 30 characters",
        ];
    }
}
