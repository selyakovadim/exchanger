<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Alert
 * @package App\Models
 *
 * @property int $id
 * @property string $text
 */
class Alert extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;
        $this->guarded = [];

        parent::__construct($attributes);
    }

    public static function random()
    {
        $alerts = Cache::remember('alerts', 60, function () {
            return static::all(['text']);
        });

        return $alerts->random()->text;
    }
}
