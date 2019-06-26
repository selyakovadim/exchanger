<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exchange;

class OperationsController extends Controller
{
    public function index()
    {
       return view('user.operations', [

           'exchanges' => Exchange::owned()
               ->with('route')
               ->reverse()
               ->paginate(5),

           'completed' => Exchange::owned()
               ->status(Exchange::SUCCESS)
               ->count(),

       ]);
    }
}
