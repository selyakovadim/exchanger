<?php

namespace App\Observers;

use App\Models\Address;
use App\Models\Bill;
use App\Models\Exchange;

class BillObserver
{
    public function created(Bill $bill)
    {
        if ($bill->currency === 'BTC') {
            $address = Address::free();
            $address->bill_id = $bill->id;
            return $address->save();
        }

        return true;
    }

    public function updated(Bill $bill)
    {
        if ($bill->status === Bill::SUCCESS) {

            $exchange = Exchange::where('bill_id', $bill->id)
                ->first();

            if ($exchange !== null) {
                return $exchange->paid();
            }
        }

        if ($bill->status === Bill::CANCELED) {

            if ($bill->currency === 'BTC') {
                $address = $bill->address;
                $address->bill_id = null;
                return $address->save();
            }
        }

        return true;
    }
}