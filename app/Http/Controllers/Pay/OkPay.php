<?php

namespace App\Http\Controllers\Pay;


class OkPay extends PaymentBase
{
    protected function check()
    {
        $request = 'ok_verify=true';

        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $request .= "&$key=$value";
        }

        $fsocket = false;
        $result = false;

        if ($fp = @fsockopen('ssl://checkout.okpay.com', 443, $errno, $errstr, 30) ) {
            $fsocket = true;
        } elseif ($fp = @fsockopen('checkout.okpay.com', 80, $errno, $errstr, 30)) {
            $fsocket = true;
        }

        if ($fsocket == true) {
            $header = 'POST /ipn-verify HTTP/1.1' . "\r\n" .
                'Host: checkout.okpay.com'."\r\n" .
                'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
                'Content-Length: ' . strlen($request) . "\r\n" .
                'Connection: close' . "\r\n\r\n";

            @fputs($fp, $header . $request);
            $string = '';
            while (!@feof($fp)) {
                $res = @fgets($fp, 1024);
                $string .= $res;
                if ($res == 'VERIFIED' || $res == 'INVALID' || $res == 'TEST') {
                    $result = $res;
                    break;
                }
            }
            @fclose($fp);
        }

        return $result === "VERIFIED"
            && $this->request->input('ok_txn_status') == 'completed'
            && $this->request->input('ok_receiver') == $this->sci_account;
    }

    protected function responseFail()
    {
        return $this->getOrderId() . '|error';
    }

    protected function responseSuccess()
    {
    }

    protected function getOrderId()
    {
        return $this->request->input('ok_invoice');
    }

    protected function getAmount()
    {
        return $this->request->input('ok_txn_amount');
    }

    protected function getCurrency()
    {
        return $this->request->input('ok_txn_currency');
    }

    protected function getTransaction()
    {
        return $this->request->input('ok_txn_id');
    }
}