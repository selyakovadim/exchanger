<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        return view('partner.account', [

            'referrals' => User::referred()
                ->count(),

            'exchanges' => Exchange::referred()
                ->status(Exchange::SUCCESS)
                ->count(),
        ]);
    }
}