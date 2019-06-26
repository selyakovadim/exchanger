<?php

namespace App\Modules\Payouts;

use GuzzleHttp\Client;

abstract class PayoutBase
{
    protected $number;
    protected $amount;
    protected $comment;
    protected $currency;

    protected $api_account;
    protected $api_id;
    protected $api_key;

    public function __construct($number, $amount, $currency, $comment)
    {
        $this->number = $number;
        $this->amount = $amount;
        $this->comment = $comment;
        $this->currency = $currency;

        $class = class_basename($this);

        $this->api_account = config("payment.$class.api.account");
        $this->api_id = config("payment.$class.api.id");
        $this->api_key = config("payment.$class.api.key");
    }


    public function pay()
    {
        $client = new Client();
        $response = $client->request(
            $this->getHttpMethod(),
            $this->getPaymentUrl(), [
                'query' => $this->getPaymentParameters(),
            ]
        );

        return $this->getResult($response->getBody());
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * URL оплаты
     *
     * @return string
     */
    abstract protected function getPaymentUrl();

    /**
     * Параметры платежа
     *
     * @return array
     */
    abstract protected function getPaymentParameters();

    /**
     * Обработчик результата платежа
     *
     * @param $response string ответ платежной системы
     * @return string номер транзакции
     */
    abstract protected function getResult($response);

    /**
     * Метод http запроса GET или POST
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'GET';
    }
}