<?php

namespace App\Modules\Payouts;


class PayoutFactory
{
    /**
     * @param $system
     * @param $number
     * @param $amount
     * @param $currency
     * @param $comment
     * @return PayoutBase
     */
    public static function produce($system, $number, $amount, $currency, $comment)
    {
        $class = __NAMESPACE__ . '\\' . $system;
        if (class_exists($class)) {
            return new $class($number, $amount, $currency, $comment);
        }

        throw new \Exception('Класса для выплат не существует');
    }
}