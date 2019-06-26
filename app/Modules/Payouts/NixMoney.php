<?php

namespace App\Modules\Payouts;

final class NixMoney extends PayoutBase
{
    /**
     * URL оплаты
     *
     * @return string
     */
    protected function getPaymentUrl()
    {
        return 'https://www.nixmoney.com/send';
    }

    /**
     * Параметры платежа
     *
     * @return array
     */
    protected function getPaymentParameters()
    {
        return [
            'PASSPHRASE' => $this->api_key,
            'PAYER_ACCOUNT' => $this->api_account,
            'PAYEE_ACCOUNT' => $this->number,
            'AMOUNT' => $this->amount,
            'PAY_IN' => '1',
            'MEMO' => $this->comment,
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