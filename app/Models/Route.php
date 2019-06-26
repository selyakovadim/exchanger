<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Route
 * @package App\Models
 *
 * @property int $id
 * @property Reserve $reserve_from
 * @property Reserve $reserve_to
 * @property string $rate
 * @property string $type
 */
class Route extends Model
{
    const MANUAL = 'manual'; // ручной прием
    const SEMIAUTO = 'semiauto'; // ручные выплаты
    const AUTO = 'auto'; // автоматический обмен

    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        $this->with = [
            'reserve_from',
            'reserve_to',
        ];

        parent::__construct($attributes);
    }

    /**
     * Резерв, с которого идет обмен
     */
    public function reserve_from()
    {
        return $this->hasOne(Reserve::class, 'id', 'reserve_from_id');
    }

    /**
     * Резерв, на который идет обмет
     */
    public function reserve_to()
    {
        return $this->hasOne(Reserve::class, 'id', 'reserve_to_id');
    }

    /**
     * Поиск маршрута по резервам
     * @param Reserve $from резерв с которого идет обмен
     * @param Reserve $to резерв на который идет обмен
     */
    public function scopeCurrent($query, Reserve $from, Reserve $to)
    {
        return $query
            ->where('reserve_from_id', $from->id)
            ->where('reserve_to_id', $to->id);
    }

    public static function all($columns = ['*'])
    {
        return Cache::remember('routes', 20, function () use ($columns) {
            return parent::all($columns);
        });
    }
}
