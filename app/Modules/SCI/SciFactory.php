<?php

namespace App\Modules\SCI;

class SciFactory
{
    public static function produce($system)
    {
        $class = __NAMESPACE__ . '\\' . $system;
        $sci = new $class();

        return $sci;
    }
}