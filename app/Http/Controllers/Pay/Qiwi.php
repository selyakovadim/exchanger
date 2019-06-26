<?php

namespace App\Http\Controllers\Pay;


class Qiwi extends PaymentBase
{

    protected function check()
    {
        return false;
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
        return $this->request->input('order_id');
    }

    protected function getAmount()
    {
        return $this->request->input('amount');
    }

    protected function getCurrency()
    {
        return 'RUB';
    }

    protected function getTransaction()
    {
        return $this->request->input('transaction');
    }
}