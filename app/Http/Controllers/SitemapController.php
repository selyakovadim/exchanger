<?php

namespace App\Http\Controllers;

use App\Models\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $routes = Route::all();

        return response(view('sitemap', compact('routes')))
            ->header('Content-Type', 'text/xml');
    }
}