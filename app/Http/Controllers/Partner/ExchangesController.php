<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Exchange;

class ExchangesController extends Controller
{
    public function index()
    {
        return view('partner.exchanges', [

            'exchanges' => Exchange::referred()
                ->status(Exchange::SUCCESS)
                ->reverse()
                ->paginate(5),
        ]);
    }
}
