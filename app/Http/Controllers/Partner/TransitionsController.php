<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Transition;

class TransitionsController extends Controller
{
    public function index()
    {
        return view('partner.transitions', [

            'transitions' => Transition::referred()
                ->reverse()
                ->paginate(10),
        ]);
    }
}
