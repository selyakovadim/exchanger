<?php

namespace App\Modules\Payouts;

require_once __DIR__ . '/../../Libraries/CPayeer.php';

use CPayeer;

final class Payeer extends PayoutBase
{
    private $api;

    /**
     * Payeer constructor.
     */
    public function __construct($number, $amount, $currency, $comment)
    {
        parent::__construct($number, $amount, $currency, $comment);

        $this->api = new CPayeer($this->api_account, $this->api_id, $this->api_key);
    }

    public function pay()
    {
        $response = $this->api->transfer($this->getPaymentParameters());
        return $this->getResult($response);
    }

    /**
     * URL оплаты
     *
     * @return string
     */
    protected function getPaymentUrl()
    {
        return;
    }

    /**
     * Параметры платежа
     *
     * @return array
     */
    protected function getPaymentParameters()
    {
        return [
            'curIn' => $this->currency,
            'sumOut' => $this->amount,
            'curOut' => $this->currency,
            'to' => $this->number,
            'comment' => $this->comment,
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
        return $response['historyId'];
    }
}