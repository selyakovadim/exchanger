<?php

namespace App\Modules\Payouts;

class Bitcoin extends PayoutBase
{
    /**
     * URL оплаты
     *
     * @return string
     */
    protected function getPaymentUrl()
    {
        return 'https://block.io/api/v2/withdraw_from_addresses/';
    }

    /**
     * Параметры платежа
     *
     * @return array
     */
    protected function getPaymentParameters()
    {
        return [
            'api_key' => $this->api_key,
            'pin' => $this->api_id,
            'from_addresses' => $this->api_account,
            'amounts' => $this->amount,
            'to_address' => $this->number,
        ];
    }

    /**
     * Обработчик результата платежа
     *
     * @param $response string ответ платежной системы
     * @return string номер транзакции
     */
    protected function getResult($response)
    {
        return json_decode($response, true)['data']['txid'];
    }
}