<?php

namespace App\Modules\Payouts;

use SoapClient;

class OkPay extends PayoutBase
{
    public function pay()
    {
        try {
            $secWord  = $this->api_key; // wallet API password
            $WalletID = $this->api_id; // wallet ID

            $datePart = gmdate("Ymd:H");
            $authString = $secWord.":".$datePart;

            $secToken = hash('sha256', $authString);
            $secToken = strtoupper($secToken);

            $client = new SoapClient("https://api.okpay.com/OkPayAPI?wsdl");

            $client->WalletID = $WalletID;
            $client->SecurityToken = $secToken;
            $client->Currency = $this->getCurrency();
            $client->Receiver = $this->getNumber();
            $client->Amount = $this->getAmount();
            $client->Comment = $this->getComment();
            $client->IsReceiverPaysFees = FALSE;

            $webService  = $client->Send_Money($client);
            $result = $webService->Send_MoneyResult;

            return $result->ID;
        } catch (\Exception $e) {
            return false;
        }
    }


    protected function getPaymentUrl()
    {
    }

    /**
     * Параметры платежа
     *
     * @return array
     */
    protected function getPaymentParameters()
    {
    }

    /**
     * Обработчик результата платежа
     *
     * @param $response string ответ платежной системы
     * @return string номер транзакции
     */
    protected function getResult($response)
    {
    }
}