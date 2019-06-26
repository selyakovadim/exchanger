<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserData
 * @package App\Models
 *
 * @property int $id
 * @property User $user
 * @property string $key
 * @property string $value
 */
class UserData extends Model
{
    use Owned;

    const NAME = 'name';
    const DISCOUNT = 'discount';
    const SUM_EXCHANGE = 'sum_exchange';
    const REFERRER_PERCENT = 'referrer_percent';

    public function __construct(array $attributes = [])
    {
        $this->table = 'users_data';
        $this->guarded = [];
        $this->timestamps = false;

        $this->casts = [
            'key' => 'string',
            'value' => 'string',
        ];

        parent::__construct($attributes);
    }
}
