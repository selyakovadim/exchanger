<?php

namespace App\Twig;

use Twig_Extension;
use Twig_SimpleFilter;

class Filters extends Twig_Extension
{
    public function getFilters()
    {
        return [

            new Twig_SimpleFilter('date', function ($date) {
                return $date ? $date->format('d.m.Y H:i') : '';
            }),

            new Twig_SimpleFilter('symbol', function ($currency) {
                if ($currency === 'RUB') return '₽';
                if ($currency === 'USD') return '$';
                if ($currency === 'BTC') return '฿';
                if ($currency === 'EUR') return '€';

                return $currency;
            }),

        ];
    }
}