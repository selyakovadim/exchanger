<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExchangeRequest;
use App\Models\Bill;
use App\Models\Exchange;
use App\Models\Reserve;
use App\Models\Route;
use App\Models\UserWallet;
use App\Modules\Money\Money;
use Illuminate\Support\Facades\DB;

class ExchangeController extends Controller
{
    public function index(Reserve $from, Reserve $to)
    {
        return view('exchange.index', [

            'from' => $from,

            'to' => $to,

            'route' => Route::current($from, $to)
                ->firstOrFail(),

            'wallet' => UserWallet::owned()
                ->select('number')
                ->where('reserve_id', $to->id)
                ->first(),

            'reserves' => Reserve::all(),

        ]);
    }

    public function create(ExchangeRequest $request, Reserve $from, Reserve $to)
    {
        $route = Route::current($from, $to)
            ->firstOrFail();

        $user = $request->user();

        $from_amount = new Money($request->input('from_amount'), $from->currency);
        $from_amount = $from_amount->truncate();

        $from_system_commission = $from_amount
            ->percent($from->commission)
            ->round();

        $to_amount = $from_amount
            ->subtract($from_system_commission);

        $to_amount = $to_amount->multiply($route->rate);

        $to_system_commission = $to_amount
            ->percent($to->commission)
            ->round();

        if (preg_match('/\+380[0-9]{6,14}/', $request->input('to_wallet'))) {
            $to_system_commission = $to_amount
                ->percent(1)
                ->round();
        }

//        if ($to_system_commission->lt($to->min_commission)) {
//            $to_system_commission = $to->min_commission;
//        }

        $to_amount = $to_amount
            ->subtract($to_system_commission);

        $referrer_reward = $to_amount->multiply(0.005);

        $bill = new Bill([
            'user_id' => $user ? $user->id : null,
            'amount' => $from_amount->subtract($from_system_commission),
            'currency' => $from->currency,
        ]);

        $exchange = new Exchange([
            'user_id' => $user ? $user->id : null,
            'referrer_id' => $user ? $user->referrer_id : session('referrer_id'),
            'route_id' => $route->id,
            'from_amount' => $from_amount,
            'from_commission' => $from_system_commission,
            'to_amount' => $to_amount,
            'to_commission' => $to_system_commission,
            'referrer_reward' => $referrer_reward,
            'to_wallet' => $request->input('to_wallet'),
            'hash' => hash('sha256', 'AQJ2vsPratNe' . time()),
        ]);

        $exchange = DB::transaction(function () use ($bill, $exchange) {
            $bill->save();
            $exchange->bill_id = $bill->id;
            $exchange->save();
            return $exchange;
        });

        if ($route->reserve_from->system === 'YandexMoney') {
            $request->session()->put('order_id', $bill->id);
        }

        if ($route->reserve_from->system === 'NixMoney') {
            $request->session()->put('order_id', $bill->id);
        }

        return redirect()->route('exchange.show', $exchange);
    }

    public function show(Exchange $exchange)
    {
        return view('exchange.show', compact('exchange'));
    }

    public function confirm(Exchange $exchange)
    {
        $exchange->pending();
        return back();
    }
}
