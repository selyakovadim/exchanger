<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FeedBack
 * @package App\Models
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property Exchange $exchange
 * @property string $message
 */
class FeedBack extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->table = 'feedbacks';

        $this->fillable = [
            'username',
            'email',
            'exchange_id',
            'message',
        ];

        parent::__construct($attributes);
    }

    public function exchange()
    {
        return $this->hasOne(Exchange::class, 'id', 'exchange_id');
    }
}
