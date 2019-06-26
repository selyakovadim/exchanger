<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Route;
use App\Models\Transition;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index', [

            'reserves' => Reserve::all(),

            'routes' => Route::all(),

        ]);
    }

    public function referral(Request $request, $referrer_id)
    {
        $user = User::find($referrer_id);

        if ($user !== null) {

            Transition::create([
                'referrer_id' => $referrer_id,
                'site' => $request->server('HTTP_REFERER', 'Прямой переход'),
            ]);

            session()->put('referrer_id', $referrer_id);
        }

        return redirect()->route('index');
    }
}
