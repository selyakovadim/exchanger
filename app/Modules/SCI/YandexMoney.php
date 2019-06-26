<?php

namespace App\Modules\SCI;

use App\Models\Bill;

class YandexMoney extends SciBase
{
    public function getURL()
    {
        return 'https://money.yandex.ru/quickpay/confirm.xml';
    }

    public function getParameters(Bill &$bill)
    {
        return [
            'receiver' => $this->sci_account,
            'formcomment ' => $this->getComment($bill->id),
            'short-dest' => $this->getComment($bill->id),
            'quickpay-form' => 'donate',
            'label' => $bill->id,
            'need-fio' => 'false',
            'need-email' => 'false',
            'need-phone' => 'false',
            'need-address' => 'false',
            'targets' => $this->getComment($bill->id),
            'sum' => $bill->amount->multiply(1.005),
            'paymentType' => 'PC',
            'successURL' => route('payment.yandexmoney.success'),
        ];
    }
}