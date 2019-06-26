<?php

namespace App\Http\Controllers\Pay;

class Payeer extends PaymentBase
{
    protected function check()
    {
        $ar_hash = [
            $this->request->input('m_operation_id'),
            $this->request->input('m_operation_ps'),
            $this->request->input('m_operation_date'),
            $this->request->input('m_operation_pay_date'),
            $this->request->input('m_shop'),
            $this->request->input('m_orderid'),
            $this->request->input('m_amount'),
            $this->request->input('m_curr'),
            $this->request->input('m_desc'),
            $this->request->input('m_status'),
            $this->sci_key,
        ];

        $sign_hash = strtoupper(hash('sha256', implode(':', $ar_hash)));

        return $this->request->input('m_sign') === $sign_hash &&
        $this->request->input('m_status') === 'success';
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
        return $this->request->input('m_orderid');
    }

    protected function getAmount()
    {
        return $this->request->input('m_amount');
    }

    protected function getCurrency()
    {
        return $this->request->input('m_curr');
    }

    protected function getTransaction()
    {
        return $this->request->input('m_operation_id');
    }
}
