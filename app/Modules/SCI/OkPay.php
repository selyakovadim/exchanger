<?php

namespace App\Modules\SCI;

use App\Models\Bill;

class OkPay extends SciBase
{

    public function getURL()
    {
        return 'https://checkout.okpay.com/';
    }

    public function getParameters(Bill &$bill)
    {
        return [
            'ok_receiver' => $this->sci_account,
            'ok_invoice'  => $bill->id,
            'ok_return_success' => route('payment.okpay.success'),
            'ok_return_fail' => route('payment.okpay.fail'),
            'ok_language' => 'RUS',
            'ok_item_1_name' => $this->getComment($bill->id),
            'ok_item_1_price' => $bill->amount,
            'ok_currency' => $bill->currency,
            'ok_ipn'=> route('payment.okpay'),
        ];
    }
}