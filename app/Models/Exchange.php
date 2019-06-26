<?php

namespace App\Models;

use App\Modules\Money\Money;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Exchange
 * @package App\Models
 *
 * @property int $id
 * @property Bill $bill
 * @property User $user
 * @property User $referrer
 * @property Route $route
 * @property Money $from_amount
 * @property Money $from_commission
 * @property Money $to_commission
 * @property Money $to_amount
 * @property Money $referrer_reward
 * @property string $to_wallet
 * @property string $transaction
 * @property string $status
 * @property string $hash
 */
class Exchange extends Model
{
    use Owned, Reverse;

    const WAITING = 'waiting';
    const PENDING = 'pending';
    const PAID = 'paid';
    const CANCELED = 'canceled';
    const SUCCESS = 'success';

    public function __construct(array $attributes = [])
    {
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'id', 'bill_id');
    }

    public function referrer()
    {
        return $this->hasOne(User::class, 'id', 'referrer_id');
    }

    public function route()
    {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }

    public function getFromAmountAttribute($value)
    {
        return new Money($value, $this->route->reserve_from->currency);
    }

    public function getFromCommissionAttribute($value)
    {
        return new Money($value, $this->route->reserve_from->currency);
    }

    public function getToCommissionAttribute($value)
    {
        return new Money($value, $this->route->reserve_to->currency);
    }

    public function getToAmountAttribute($value)
    {
        return new Money($value, $this->route->reserve_to->currency);
    }

    public function getReferrerRewardAttribute($value)
    {
        return new Money($value, $this->route->reserve_to->currency);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeReferred($query)
    {
        return $query->where('referrer_id', Auth::id());
    }

    public function scopeExpired($query)
    {
        return $query->status('waiting')
            ->where('created_at', '<', Carbon::now()->subMinutes(1440));
    }

    public function cancel()
    {
        $this->status = Exchange::CANCELED;
        $this->transaction = null;
        return $this->save();
    }

    public function paid()
    {
        $this->status = Exchange::PAID;
        return $this->save();
    }

    public function success($transaction)
    {
        $this->status = Exchange::SUCCESS;
        $this->transaction = $transaction;
        return $this->save();
    }

    public function pending()
    {
        $this->status = Exchange::PENDING;
        return $this->save();
    }

    public function getRouteKeyName()
    {
        return 'hash';
    }
}
