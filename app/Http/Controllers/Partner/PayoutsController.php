<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Http\Requests\PayoutRequest;
use App\Models\Payout;
use App\Models\Reserve;
use App\Models\UserBalance;
use App\Models\UserWallet;
use App\Modules\Money\Money;
use App\Notifications\PayoutNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PayoutsController extends Controller
{
    public function index()
    {
        $wallets = [];

        foreach (UserWallet::owned()->get() as $wallet) {
            $wallets[$wallet->reserve_id] = $wallet->number;
        }

        return view('partner.payouts', [

            'reserves' => Reserve::select([
                'id', 'system', 'currency'
            ])->get(),

            'user_wallets' => $wallets,

            'payouts' => Payout::owned()
                ->reverse()
                ->paginate(5),
        ]);
    }

    public function create(PayoutRequest $request)
    {
        $reserve_id = (int) $request->input('valut_id');
        $reserve = Reserve::whereId($reserve_id)->first();

        $amount = new Money($request->input('amount'), $reserve->currency);
        $amount = $amount->truncate();

        $payout = new Payout([
            'user_id' => $request->user()->id,
            'system' => $reserve->system,
            'amount' => $amount,
            'currency' => $reserve->currency,
            'wallet' => $request->input('account'),
        ]);

        $balance = UserBalance::owned()
            ->where('currency', $reserve->currency)
            ->first();

        $balance->amount = $balance->amount->subtract($amount);

        DB::transaction(function () use ($payout, $balance) {
            $payout->save() && $balance->save();
        });

        Notification::send($payout, new PayoutNotification());

        session()->flash(
            'message-success',
            'Заявка на выплату успешно создана'
        );

        return back();
    }
}
