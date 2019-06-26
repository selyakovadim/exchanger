<?php

namespace App\Modules\SCI;

use App\Models\Bill;
use Illuminate\Support\Facades\Request;

final class PerfectMoney extends SciBase
{
    public function getURL()
    {
        return 'https://perfectmoney.is/api/step1.asp';
    }

    public function getParameters(Bill &$bill)
    {
        return [
            'PAYEE_ACCOUNT' => $this->sci_account,
            'PAYEE_NAME' => Request::server ('HTTP_HOST'),
            'PAYMENT_ID' => $bill->id,
            'PAYMENT_AMOUNT' => $bill->amount,
            'PAYMENT_UNITS' => $bill->currency,
            'STATUS_URL' => route('payment.perfectmoney'),
            'PAYMENT_URL' => route('payment.perfectmoney.success'),
            'PAYMENT_URL_METHOD' => $this->getHttpMethod(),
            'NOPAYMENT_URL' => route('payment.perfectmoney.fail'),
            'NOPAYMENT_URL_METHOD' => $this->getHttpMethod(),
            'BAGGAGE_FIELDS' => "",
            'PAYMENT_METHOD' => 'PerfectMoney account',
            'SUGGESTED_MEMO' => $this->getComment($bill->id),
        ];
    }
}