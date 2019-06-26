<?php

namespace App\Modules\Payouts;

final class PerfectMoney extends PayoutBase
{
    /**
     * URL оплаты
     *
     * @return string
     */
    protected function getPaymentUrl()
    {
        return 'https://perfectmoney.is/acct/confirm.asp';
    }

    /**
     * Параметры платежа
     *
     * @return array
     */
    protected function getPaymentParameters()
    {
        return [
            'AccountID' => $this->api_id,
            'PassPhrase' => $this->api_key,
            'Payer_Account' => $this->api_account,
            'Payee_Account' => $this->number,
            'Amount' => $this->amount,
            'PAY_IN' => '1',
            'Memo' => $this->comment,
        ];
    }

    /**
     * Обработчик результата платежа
     *
     * @param $response string ответ платежной системы
     * @return string|bool номер транзакции или false в случае ошибки
     */
    protected function getResult($response)
    {
        if(!preg_match_all("/<input name='(.*)' type='hidden' value='(.*)'>/", $response, $data, PREG_SET_ORDER)) {
            return false;
        }

        $result = [];
        foreach($data as $item){
            $result[$item[1]] = $item[2];
        }

        return isset($result['PAYMENT_BATCH_NUM']) && !isset($result['ERROR']) ? $result['PAYMENT_BATCH_NUM'] : false;
    }
}