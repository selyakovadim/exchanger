<?php

namespace App\Modules\SCI;

use App\Models\Bill;

final class Qiwi extends SciBase
{
    public function getURL()
    {
        return 'https://qiwi.com/payment/transfer/form.action';
    }

    public function getParameters(Bill &$bill)
    {
        $amountInteger = $bill->amount->truncate(0);
        $amountFraction = $bill->amount->subtract($amountInteger)->multiply(100);

        return [
            'extra[\'account\']' => $this->sci_account,
            'extra[\'comment\']' => $this->getComment($bill->id),
            'amountInteger' => $amountInteger,
            'amountFraction' => $amountFraction,
        ];
    }

    public function getComment($id)
    {
        return $id;
    }
}