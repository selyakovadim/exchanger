<?php

namespace App\Http\Controllers;

class RulesController extends Controller
{
    public function index()
    {
        return view('rules', []);
    }
}
