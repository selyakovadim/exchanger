<?php

namespace App\Models;

use App\Modules\Money\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reserve
 * @package App\Models
 *
 * @property int $id
 * @property string $system
 * @property string $currency
 * @property Money $balance
 * @property Money $min
 * @property Money $min_commission
 * @property float $commission
 * @property string $label
 * @property string $regex
 * @property string $placeholder
 */
class Reserve extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    public function getBalanceAttribute($value)
    {
        return new Money($value, $this->currency);
    }

    public function getMinAttribute($value)
    {
        return new Money($value, $this->currency);
    }

    public function getMinCommissionAttribute($value)
    {
        return new Money($value, $this->currency);
    }

    public function getRouteKeyName()
    {
        return 'label';
    }

    public function __toString()
    {
        if ($this->system === 'Bitcoin') return 'Bitcoin';
        if ($this->system === 'Tinkoff') return 'Тинькофф';
        if ($this->system === 'Sberbank') return 'Сбербанк';
        if ($this->system === 'Qiwi') return 'QIWI Кошелек';
        if ($this->system === 'YandexMoney') return 'Яндекс.Деньги';
        if ($this->system === 'PerfectMoney') return 'Perfect Money';


        return $this->system . ' ' . $this->currency;
    }
}
