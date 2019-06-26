<?php

namespace App\Modules\SCI;

use App\Models\Bill;
use Illuminate\Support\Facades\Request;

class NixMoney extends SciBase
{

    public function getURL()
    {
        return 'https://www.nixmoney.com/merchant.jsp';
    }

    public function getParameters(Bill &$bill)
    {
        return [
            'PAYEE_ACCOUNT' => $this->sci_account,
            'PAYEE_NAME' => Request::server ('HTTP_HOST'),
            'PAYMENT_ID' => $bill->id,
            'PAYMENT_AMOUNT' => $bill->amount,
            'PAYMENT_UNITS' => $bill->currency,
            'STATUS_URL' => route('payment.nixmoney'),
            'PAYMENT_URL' => route('payment.nixmoney.success'),
            'PAYMENT_URL_METHOD' => "POST",
            'NOPAYMENT_URL' => route('payment.nixmoney.fail'),
            'NOPAYMENT_URL_METHOD' => "POST",
            'BAGGAGE_FIELDS' => "",
            'PAYMENT_METHOD' => 'nixmoneyMoney account',
            'SUGGESTED_MEMO' => $this->getComment($bill->id),
        ];
    }
}