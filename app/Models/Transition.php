<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Transition
 * @package App\Models
 *
 * @property int $id
 * @property string $site
 * @property User $referrer
 */
class Transition extends Model
{
    use Reverse;

    public function __construct(array $attributes = [])
    {
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public function referrer()
    {
        return $this->hasOne('users', 'id', 'referrer_id');
    }

    /**
     * Список переходов для реферовода
     */
    public function scopeReferred($query)
    {
        return $query->where('referrer_id', Auth::id());
    }
}
