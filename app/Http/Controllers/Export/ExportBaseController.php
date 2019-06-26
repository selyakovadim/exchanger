<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use App\Models\Route;

abstract class ExportBaseController extends Controller
{
    public function index()
    {
        $routes = Route::with(['reserve_from', 'reserve_to'])
            ->get();

        return response(view($this->getView(), compact('routes')))
            ->header('Content-Type', $this->getContentType());
    }

    abstract protected function getContentType();

    abstract protected function getView();
}
