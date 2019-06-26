<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * Class Partner
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property bool $index
 */
class Partner extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    public function scopeVisible($query)
    {
        return $query->where('index', '1');
    }
}
