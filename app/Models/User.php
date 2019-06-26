<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * Class User
 * @package App\Models
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property User $referrer
 */
class User extends Authenticatable
{
    use Notifiable, Reverse;

    public function __construct(array $attributes = [])
    {
        $this->fillable = [
            'email',
            'password',
            'referrer_id',
        ];

        parent::__construct($attributes);
    }

    public function referrer()
    {
        return $this->hasOne(User::class, 'id', 'referrer_id');
    }

    public function scopeReferred($query)
    {
        return $query->where('referrer_id', Auth::id());
    }

    public function changePassword($password)
    {
        $this->password = bcrypt($password);
        return $this->save();
    }
}