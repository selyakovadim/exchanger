<?php

namespace App\Models;

trait Reverse
{
    public function scopeReverse($query)
    {
        return $query->orderBy('id', 'desc');
    }
}