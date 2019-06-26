<?php

namespace App\Models;

use App\Modules\Money\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payout
 * @package App\Models
 *
 * @property int $id
 * @property User $user
 * @property string $system
 * @property string $currency
 * @property Money $amount
 * @property string $wallet
 * @property string $transaction
 * @property string $status
 */
class Payout extends Model
{
    use Reverse, Owned;

    const PENDING = 'pending';
    const CANCELED = 'canceled';
    const SUCCESS = 'success';

    public function __construct(array $attributes = [])
    {
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public function getAmountAttribute($value)
    {
        return new Money($value, $this->currency);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
