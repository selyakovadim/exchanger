<?php

namespace App\Http\Controllers\Pay;

use App\Models\Exchange;

class YandexMoney extends PaymentBase
{
    protected function check()
    {
        if ($this->request->input('unaccepted') === 'true' ||
            $this->request->input('codepro') !== 'false') {
            return false;
        }

        $ar_hash = [
            $this->request->input('notification_type'),
            $this->request->input('operation_id'),
            $this->request->input('amount'),
            $this->request->input('currency'),
            $this->request->input('datetime'),
            $this->request->input('sender'),
            $this->request->input('codepro'),
            $this->sci_key,
            $this->request->input('label'),
        ];

        $sign_hash = hash('sha1', implode('&', $ar_hash));

        return $sign_hash === $this->request->input('sha1_hash');
    }

    protected function redirect()
    {
        $exchange = Exchange::where('bill_id', $this->request->session()->pull('order_id'))
            ->select('hash')
            ->first();

        if ($exchange) {
            return redirect()->route('exchange.show', $exchange);
        }

        return redirect()->route('index');
    }

    protected function responseFail()
    {
        return abort(404);
    }

    protected function responseSuccess()
    {
    }

    protected function getOrderId()
    {
        return $this->request->input('label');
    }

    protected function getAmount()
    {
        return $this->request->input('withdraw_amount');
    }

    protected function getCurrency()
    {
        return 'RUB';
    }

    protected function getTransaction()
    {
        return $this->request->input('operation_id');
    }
}
