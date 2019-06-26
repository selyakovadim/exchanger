<?php

namespace App\Http\Controllers;

use App\Models\Reserve;
use App\Models\Route;

class TariffsController extends Controller
{
    public function index()
    {
        return view('tariffs', [

            'reserves' => Reserve::all(),

            'routes' => Route::all(),

        ]);
    }
}
