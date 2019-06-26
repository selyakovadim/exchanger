<?php

namespace App\Modules\SCI;

use App\Models\Bill;

final class AdvCash extends SciBase
{
    public function getURL()
    {
        return 'https://wallet.advcash.com/sci/';
    }

    public function getParameters(Bill &$bill)
    {
        $arHash = [
            $this->sci_account,
            $this->sci_id,
            $bill->amount,
            $bill->currency,
            $this->sci_key,
            $bill->id,
        ];

        $sign = hash('sha256', implode(':', $arHash));

        return [
            'ac_account_email' => $this->sci_account,
            'ac_sci_name' => $this->sci_id,
            'ac_amount' => $bill->amount,
            'ac_currency' => $bill->currency,
            'ac_order_id' => $bill->id,
            'ac_sign' => $sign,
            'ac_comments' => $this->getComment($bill->id),
        ];
    }
}