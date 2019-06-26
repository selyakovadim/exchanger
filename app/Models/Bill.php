<?php

namespace App\Models;

use App\Modules\Money\Money;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Bill
 * @package App\Models
 *
 * @property int $id
 * @property User $user
 * @property Money $amount
 * @property string $currency
 * @property string $transaction
 * @property string $status
 * @property Address $address
 */
class Bill extends Model
{
    const SUCCESS = 'success';
    const CANCELED = 'canceled';
    const WAITING = 'waiting';

    public function __construct(array $attributes = [])
    {
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'bill_id', 'id');
    }

    public function getAmountAttribute($value)
    {
        return new Money($value, $this->currency);
    }

    public function confirm($transaction)
    {
        $this->transaction = $transaction;
        $this->status = Bill::SUCCESS;
        return $this->save();
    }

    public function cancel()
    {
        $this->transaction = null;
        $this->status = Bill::CANCELED;
        return $this->save();
    }
}
