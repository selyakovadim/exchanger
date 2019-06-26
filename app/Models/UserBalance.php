<?php

namespace App\Models;

use App\Modules\Money\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserBalance
 * @package App\Models
 *
 * @property int $id
 * @property User $user
 * @property string $currency
 * @property Money $amount
 */
class UserBalance extends Model
{
    use Owned;

    public function __construct(array $attributes = [])
    {
        $this->guarded = [];
        $this->table = 'users_balances';
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    public function getAmountAttribute($value)
    {
        return new Money($value, $this->currency);
    }


}
