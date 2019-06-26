<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    protected function after($instance)
    {
        if (!Hash::check($this->input('current_password'), $this->user()->getAuthPassword())) {
            $instance->errors()->add('current_password.wrong', 'Неверный текущий пароль');
        }
    }

    public function rules()
    {
        return [
            'current_password' => 'required',
            'password' => 'bail|required|min:4|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => 'Вы не ввели текущий пароль',

            'password.required' => 'Вы не ввели новый пароль',
            'password.confirmed' => 'Новые пароли не совпадают'
        ];
    }
}
