<?php

namespace App\Http\Requests;

class ForgotRequest extends FormRequest
{
    use Captcha;

    public function rules()
    {
        return [
            'email' => 'bail|required|exists:users,email'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Вы не ввели email',
            'email.exists' => 'Такого пользователя не существует',
        ];
    }
}
