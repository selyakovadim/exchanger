<?php

namespace App\Modules\Payouts;


class YandexMoney extends PayoutBase
{
    public function __construct($number, $amount, $currency, $comment)
    {
        parent::__construct($number, $amount, $currency, $comment);
        $this->api_key = $this->api_account . '.' . $this->api_key;
    }


    public function pay()
    {
        //Создаем запрос на перевод
        $postdata = http_build_query(
            array(
                'pattern_id' => 'p2p',
                'to' => $this->getNumber(),
                'amount_due' => $this->getAmount(),
                'comment' => $this->getComment(), //Комментарий к переводу, отображается в истории отправителя.
                'message' => $this->getComment(), //Комментарий к переводу, отображается получателю.
            )
        );
        //метод запроса
        $request = 'request-payment';

        $opts = array(
            'http'=>array(
                'method' => "POST",
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Bearer ".$this->api_key."\r\n",
                'content'=> $postdata
            )
        );

        $context = stream_context_create($opts);

        $file = file_get_contents('https://money.yandex.ru/api/'.$request, false, $context);
        if (!$file) {
            return false;
        }
        //преобразуем в массив
        $file = json_decode($file, true);
        //достаем идентификатор перевода
        $request_id = $file['request_id'];
        if (!$request_id) {
            return false;
        }

        //Подтверждаем перевод
        $postdata = http_build_query(
            array(
                'request_id' => $request_id,
            )
        );
        //метод запроса подтверждения перевода
        $request = 'process-payment';
        $opts = array(
            'http'=>array(
                'method' => "POST",
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Authorization: Bearer ".$this->api_key."\r\n",
                'content'=> $postdata
            )
        );

        $context = stream_context_create($opts);

        $data = file_get_contents('https://money.yandex.ru/api/'.$request, false, $context);
        //преобразуем в массив
        $data = json_decode($data, true);

        //достаем id перевода
        $payment_id = $data['payment_id'];
        if (!$payment_id) {
            return false;
        }
        return $payment_id;
    }


    /**
     * URL оплаты
     *
     * @return string
     */
    protected function getPaymentUrl()
    {
        return 'https://money.yandex.ru/api/request-payment/';
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
        $response = json_decode($response, true);
        $response['payment_id'];
    }
}