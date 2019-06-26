<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;

class TermsController extends Controller
{
    public function index()
    {
        return view('partner.terms', []);
    }
}
