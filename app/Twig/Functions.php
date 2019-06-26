<?php

namespace App\Twig;

use App\Modules\SCI\SciFactory;
use Illuminate\Support\Facades\Route;
use Twig_Extension;
use Twig_SimpleFunction;

class Functions extends Twig_Extension
{

    public function getFunctions()
    {
        return [

            new Twig_SimpleFunction('year', function () {
                return date('Y');
            }),

            new Twig_SimpleFunction('active', function ($route) {
                return Route::current()->getName() === $route;
            }),

            new Twig_SimpleFunction('sci', function ($exchange) {

                $sci = SciFactory::produce($exchange->route->reserve_from->system);

                return view('common.sci_form', [
                    'method' => $sci->getHttpMethod(),
                    'url' => $sci->getUrl(),
                    'params' => $sci->getParameters($exchange->bill),
                ]);

            }),

        ];
    }
}