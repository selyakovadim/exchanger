<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $visible
 */
class Banner extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', 1);
    }
}
