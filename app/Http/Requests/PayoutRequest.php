<?php

namespace App\Http\Requests;

use App\Models\Reserve;
use App\Models\UserBalance;
use App\Modules\Money\Money;

class PayoutRequest extends FormRequest
{

    protected function after($instance)
    {
        $reserve_id = (int) $this->input('valut_id');
        $reserve = Reserve::whereId($reserve_id)->first();

        if (!preg_match($reserve->regex, $this->input('account'))) {
            $instance->errors()->add('account.format', 'Неверный формат счёта для выплаты');
            return;
        }

        $amount = new Money($this->input('amount'), $reserve->currency);
        $amount = $amount->truncate();

        if ($amount->lt($reserve->min)) {
            $instance->errors()->add('amount.min', 'Минимум для вывода: ' . $reserve->min);
            return;
        }

        $balance = UserBalance::owned()
            ->where('currency', $reserve->currency)
            ->first();

        if ($balance === null || $balance->amount->lt($amount)) {
            $instance->errors()->add('amount.max', 'У Вас недостаточно средств');
            return;
        }
    }

    public function rules()
    {
        return [
            'valut_id' => 'bail|required|exists:reserves,id',
            'account' => 'required',
            'amount' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'valut_id.*' => 'Не выбрана платежная система',
            'account.required' => 'Не указан счёт для выплаты',
            'amount.required' => 'Не указана сумма',
        ];
    }
}
