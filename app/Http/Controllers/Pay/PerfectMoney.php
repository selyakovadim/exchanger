<?php

namespace App\Http\Controllers\Pay;

class PerfectMoney extends PaymentBase
{
    protected function check()
    {
        $ar_hash = [
            $this->request->input('PAYMENT_ID'),
            $this->request->input('PAYEE_ACCOUNT'),
            $this->request->input('PAYMENT_AMOUNT'),
            $this->request->input('PAYMENT_UNITS'),
            $this->request->input('PAYMENT_BATCH_NUM'),
            $this->request->input('PAYER_ACCOUNT'),
            strtoupper(md5($this->sci_key)),
            $this->request->input('TIMESTAMPGMT'),
        ];

        $sign_hash = strtoupper(hash('md5', implode(':', $ar_hash)));

        return $sign_hash === $this->request->input('V2_HASH');
    }

    protected function responseFail()
    {
        return 'ERROR';
    }

    protected function responseSuccess()
    {
        return 'SUCCESS';
    }

    protected function getOrderId()
    {
        return $this->request->input('PAYMENT_ID');
    }

    protected function getAmount()
    {
        return $this->request->input('PAYMENT_AMOUNT');
    }

    protected function getCurrency()
    {
        return $this->request->input('PAYMENT_UNITS');
    }

    protected function getTransaction()
    {
        return $this->request->input('PAYMENT_BATCH_NUM');
    }
}
