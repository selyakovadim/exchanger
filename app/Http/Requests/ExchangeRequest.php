<?php

namespace App\Http\Requests;

use App\Modules\Money\Money;

class ExchangeRequest extends FormRequest
{
    protected function after($instance)
    {
        $from = $this->route('from');
        $from_amount = new Money($this->input('from_amount'), $from->currency);

        $to = $this->route('to');
        $to_amount = new Money($this->input('to_amount'), $to->currency);

        if (!preg_match($to->regex, $this->input('to_wallet'))) {
            $instance->errors()->add('to_wallet.wrong_format', 'Неверный формат счёта');
        }

        if ($from_amount->lt($from->min)) {
            $instance->errors()->add('from_amount.min', 'Меньше минимальной суммы для обмена');
        }

        if ($to_amount->gt($to->balance)) {
            $instance->errors()->add('to_amount.max', 'Недостаточно денег в резерве');
        }
    }

    public function rules()
    {
        return [
            'to_wallet' => 'required',
            'from_amount' => 'bail|required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'to_wallet.required' => 'Вы не ввели номер кошелька',
            'from_amount.required' => 'Необходимо указать сумму перевода',
            'from_amount.numeric' => 'Сумма обмена должна быть числом',
        ];
    }


}
