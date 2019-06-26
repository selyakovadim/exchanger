<?php

namespace App\Http\Controllers\Export;

use App\Models\Reserve;
use App\Models\Route;

class ExportJSONController
{
    public function index()
    {
        return response()->json($this->getData());
    }

    private function getData()
    {
        $request = request();

        $ver = 1;
        if (is_numeric($request->input('ver'))) {
            $ver = (int) $request->input('ver');
        }

        return call_user_func([$this, 'ver' . $ver]);
    }

    private function ver1()
    {
        $rates = [];
        foreach (Route::all() as $route) {
            $rate = [
                'from' => $route->reserve_from->label,
                'to' => $route->reserve_to->label,
                'in' => 1,
                'out' => (float) $route->rate,
                'amount' => (float) $route->reserve_to->balance->amount(),
            ];

            if ($route->type === 'manual') {
                $rate['options'] = ['manual'];
            }

            $rates[] = $rate;
        }
        return compact('rates');
    }

    private function ver2()
    {
        $exchanges = [];
        $routes = Route::all();
        $reserves = Reserve::all();

        foreach ($reserves as $reserve) {
            foreach ($routes as $route) {
                if ($route->reserve_from_id === $reserve->id) {
                    $exchanges['from'][$reserve->label][$route->reserve_to->label] = [
                        'in' => 1,
                        'out' => (float) $route->rate,
                        'amount' => (float) $route->reserve_to->balance->amount()
                    ];

                    if ($route->type === 'manual') {
                        $exchanges['from'][$reserve->label][$route->reserve_to->label]['options'] = ['manual'];
                    }
                }
            }
        }
        return compact('exchanges');
    }
}
