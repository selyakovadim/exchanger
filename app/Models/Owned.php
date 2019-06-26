<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

trait Owned
{
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function scopeOwned($query)
    {
        return $query->where('user_id', Auth::id());
    }
}