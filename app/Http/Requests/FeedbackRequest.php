<?php

namespace App\Http\Requests;

class FeedbackRequest extends FormRequest
{
    use Captcha;

    public function rules()
    {
        return [
            'username' => 'bail|required|max:255',
            'email' => 'bail|required|email|max:255',
            'exchange_id' => 'bail|nullable|exists:exchanges,id',
            'message' => 'bail|required|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Вы не указали Ваше имя',
            'username.max' => 'Максимальная длина имени — :max символов',

            'email.required' => 'Вы не указали Ваш email',
            'email.email' => 'Неверный формат email',
            'email.max' => 'Максимальная длина email — :max символов',

            'exchange_id.*' => 'Неверный номер обмена',

            'message.required' => 'Пустое сообщение',
            'message.max' => 'Максимальная длина сообщения — :max символов',
        ];
    }
}
