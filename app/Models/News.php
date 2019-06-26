<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class News
 * @package App\Models
 *
 * @property int $id
 * @property string $title
 * @property string $text
 */
class News extends Model
{
    use Reverse;

    public function __construct(array $attributes = [])
    {
        $this->table = 'news';
        $this->guarded = [];

        static::addGlobalScope(function (Builder $builder) {
            $builder->where('created_at', '<', Carbon::now());
        });

        parent::__construct($attributes);
    }
}
