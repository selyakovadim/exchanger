<?php

namespace App\Modules\Payouts;

require_once __DIR__ . '/../../Libraries/MerchantWebService.php';

use authDTO;
use MerchantWebService;
use sendMoney;
use sendMoneyRequest;
use validationSendMoney;

final class AdvCash extends PayoutBase
{
    private $api;

    /**
     * AdvCash constructor.
     */
    public function __construct($number, $amount, $currency, $comment)
    {
        if ($currency === 'RUB') {
            $currency = 'RUR';
        }

        parent::__construct($number, $amount, $currency, $comment);

        $this->api = new MerchantWebService();
    }

    public function pay()
    {
        $arg0 = new authDTO();
        $arg0->apiName = $this->api_id;
        $arg0->accountEmail = $this->api_account;
        $arg0->authenticationToken = $this->api->getAuthenticationToken($this->api_key);

        $arg1 = new sendMoneyRequest();
        $arg1->amount = $this->getAmount();
        $arg1->currency = $this->getCurrency();
        $arg1->email = $this->getNumber();
        $arg1->note = $this->getComment();
        $arg1->savePaymentTemplate = false;

        $validationSendMoney = new validationSendMoney();
        $validationSendMoney->arg0 = $arg0;
        $validationSendMoney->arg1 = $arg1;

        $sendMoney = new sendMoney();
        $sendMoney->arg0 = $arg0;
        $sendMoney->arg1 = $arg1;

        $this->api->validationSendMoney($validationSendMoney);
        $sendMoneyResponse = $this->api->sendMoney($sendMoney);
        return $sendMoneyResponse->return;
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
        return;
    }

    /**
     * Обработчик результата платежа
     *
     * @param $response string ответ платежной системы
     * @return string номер транзакции
     */
    protected function getResult($response)
    {
        return;
    }
}