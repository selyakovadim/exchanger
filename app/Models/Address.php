<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 *
 * @property int $id
 * @property string $number
 * @property Bill $bill
 *
 */
class Address extends Model
{
    /**
     * @inheritDoc
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;

        $this->fillable = [
            'number',
            'bill',
        ];

        $this->hidden = [
            'bill_id',
        ];

        parent::__construct($attributes);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class, 'id', 'bill_id');
    }

    public static function free()
    {
        return self::where('bill_id', null)
            ->first();
    }

    public static function working()
    {
        return self::where('bill_id', '<>', null)
            ->get();
    }

    public function __toString()
    {
        return $this->number;
    }
}
