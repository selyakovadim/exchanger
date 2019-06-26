<?php

namespace App\Modules\SCI;

use App\Models\Bill;

final class Payeer extends SciBase
{
    public function getURL()
    {
        return 'https://payeer.com/merchant/';
    }

    public function getParameters(Bill &$bill)
    {
        $ar_hash = [
            $this->sci_id,
            $bill->id,
            $bill->amount,
            $bill->currency,
            base64_encode($this->getComment($bill->id)),
            $this->sci_key
        ];

        $sign = mb_strtoupper(hash('sha256', implode(':', $ar_hash)));

        return [
            'm_shop' => $this->sci_id,
            'm_orderid' => $bill->id,
            'm_amount' => $bill->amount,
            'm_curr' => $bill->currency,
            'm_desc' => base64_encode($this->getComment($bill->id)),
            'm_sign' => $sign,
        ];
    }
}