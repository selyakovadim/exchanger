<?php

namespace App\Http\Controllers;

use App\Models\Partner;

class PartnersController extends Controller
{
    public function index()
    {
        return view('partners', [
            'partners' => Partner::all(),
        ]);
    }
}
