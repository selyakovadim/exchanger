<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;

class ReferralsController extends Controller
{
    public function index()
    {
        return view('partner.referrals', [

            'referrals' => User::referred()
                ->select(['email', 'created_at'])
                ->reverse()
                ->paginate(10),
        ]);
    }
}