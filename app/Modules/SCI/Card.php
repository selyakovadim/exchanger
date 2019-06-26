<?php

namespace App\Modules\SCI;

use App\Models\Bill;

class Card extends YandexMoney
{
    public function __construct()
    {
        $this->sci_id = config('payment.YandexMoney.sci.id');
        $this->sci_key = config('payment.YandexMoney.sci.key');
        $this->sci_account = config('payment.YandexMoney.sci.account');
    }

    public function getParameters(Bill &$bill)
    {
        $parameters = parent::getParameters($bill);
        $parameters['paymentType'] = 'AC';
        $parameters['sum'] = $bill->amount->multiply(1.02);

        return $parameters;
    }
}