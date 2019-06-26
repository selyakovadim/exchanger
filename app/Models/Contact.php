<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class Contact
 * @package App\Models
 *
 * @property int $id
 * @property string $key
 * @property string $value
 */
class Contact extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        parent::__construct($attributes);
    }

    public static function all($columns = ['*'])
    {
        return Cache::remember('contacts', 24 * 60, function () {

            $items = parent::all(['key', 'value']);
            $data = [];

            foreach ($items as $item) {
                $data[$item->key] = $item->value;
            }

            return $data;

        });
    }
}
