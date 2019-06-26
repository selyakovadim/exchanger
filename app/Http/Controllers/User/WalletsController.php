<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\WalletsRequest;
use App\Models\Reserve;
use App\Models\UserWallet;
use Illuminate\Support\Facades\Auth;

class WalletsController extends Controller
{
    public function index()
    {
        return view('user.wallets', [

            'reserves' => Reserve::select([
                'id', 'system',
                'currency', 'placeholder'
            ])->get(),

            'wallets' => UserWallet::owned()
                ->with('reserve')
                ->get(),

        ]);
    }

    public function save(WalletsRequest $request)
    {
        $reserve_id = (int) $request->input('valut_id');

        UserWallet::updateOrCreate(
            ['user_id' => Auth::id(), 'reserve_id' => $reserve_id,],
            ['number' => $request->input('schet')[$reserve_id], ]
        );

        session()->flash(
            'message-success',
            'Кошелек успешно сохранён'
        );

        return back();
    }

    public function delete($id)
    {
        UserWallet::owned()
            ->findOrFail($id)
            ->delete();

        session()->flash(
            'message-success',
            'Кошелек успешно удалён'
        );

        return back();
    }
}

