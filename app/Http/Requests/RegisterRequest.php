<?php

namespace App\Http\Requests;

class RegisterRequest extends FormRequest
{
    use Captcha;

    public function rules()
    {
        return [
            'email' => 'bail|required|email|max:255|unique:users,email',
            'password' => 'bail|required|min:4|confirmed',
            'rcheck' => 'bail|required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Вы не ввели email',
            'email.email' => 'Неверный формат email',
            'email.max' => 'Максимальная длина email — :max символов',
            'email.unique' => 'Этот email уже занят',

            'password.required' => 'Вы не ввели пароль',
            'password.min' => 'Минимальная длина пароля — :min символа',
            'password.confirmed' => 'Пароли не совпадают',

            'rcheck.*' => 'Вы не согласились с правилами сервиса',
        ];
    }
}
