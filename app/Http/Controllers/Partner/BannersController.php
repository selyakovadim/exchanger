<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannersController extends Controller
{
    public function index()
    {
        return view('partner.banners', [

            'banners' => Banner::select(['name', 'image',])
                ->get(),
        ]);
    }
}
