<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
    use Captcha;

    protected function after($instance)
    {
        Auth::attempt([
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ], true);

        if (!Auth::check()) {
            $instance->errors()->add('auth.wrong', 'Неверный логин и/или пароль');
        }
    }

    public function rules()
    {
        return [
            'email' => 'bail|required|email|max:255',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Вы не указали email для входа',
            'email.email' => 'Неверный формат email',
            'email.max' => 'Максимальная длина email — :max',

            'password.required' => 'Вы не указали пароль',
        ];
    }


}
