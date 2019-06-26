<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\UserBalance;

class BalanceController extends Controller
{
    public function index()
    {
        return view('partner.balance', [

            'balances' => UserBalance::owned()
                ->select('amount', 'currency')
                ->get(),

            'pending' => Payout::owned()
                ->status(Payout::PENDING)
                ->selectRaw('sum(amount) as amount, currency')
                ->groupBy('currency')
                ->get(),

            'paid' => Payout::owned()
                ->status(Payout::SUCCESS)
                ->selectRaw('sum(amount) as amount, currency')
                ->groupBy('currency')
                ->get()
        ]);
    }
}
