<?php

namespace App\Http\Controllers\Pay;

class AdvCash extends PaymentBase
{
    protected function check()
    {
        $ar_hash = [
            $this->request->input('ac_transfer'),
            $this->request->input('ac_start_date'),
            $this->request->input('ac_sci_name'),
            $this->request->input('ac_src_wallet'),
            $this->request->input('ac_dest_wallet'),
            $this->request->input('ac_order_id'),
            $this->request->input('ac_amount'),
            $this->request->input('ac_merchant_currency'),
            $this->sci_key
        ];

        $sign_hash = hash('sha256', implode(':', $ar_hash));

        return $this->request->input('ac_hash') === $sign_hash;
    }

    protected function responseFail()
    {
        return $this->getOrderId() . '|error';
    }

    protected function responseSuccess()
    {
        return $this->getOrderId() . '|success';
    }

    protected function getOrderId()
    {
        return $this->request->input('ac_order_id');
    }

    protected function getAmount()
    {
        return $this->request->input('ac_amount');
    }

    protected function getCurrency()
    {
        $currency = $this->request->input('ac_merchant_currency');

        if ($currency !== 'RUR') {
            return $currency;
        }

        return 'RUB';
    }

    protected function getTransaction()
    {
        return $this->request->input('ac_transfer');
    }
}
