<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserWallet
 * @package App\Models
 *
 * @property int $id
 * @property User $user
 * @property Reserve $reserve
 * @property string $number
 */
class UserWallet extends Model
{
    use Owned;

    public function __construct(array $attributes = [])
    {
        $this->table = 'users_wallets';
        $this->guarded = [];
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    public function reserve()
    {
        return $this->hasOne(Reserve::class, 'id', 'reserve_id');
    }
}
