<?php

namespace App\Observers;

use App\Models\Exchange;
use App\Models\UserBalance;

class ExchangeObserver
{
    public function updating(Exchange $exchange)
    {
        if ($exchange->status === Exchange::PAID) {

            if ($exchange->referrer_id !== null) {

                $balance = UserBalance::firstOrNew([
                    'user_id' => $exchange->referrer_id,
                    'currency' => $exchange->route->reserve_to->currency,
                ]);

                $balance->amount = $balance->amount->add($exchange->referrer_reward);

                return $balance->save();
            }
        }

        return true;
    }
}