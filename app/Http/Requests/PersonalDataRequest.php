<?php

namespace App\Http\Requests;


class PersonalDataRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Вы не ввели имя',
            'name.max' => 'Максимальная длина имени — :max символов'
        ];
    }
}
