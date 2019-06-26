<?php

namespace App\Modules\Money;

use App\Models\Currency;
use InvalidArgumentException;

/**
 * Class Money
 */
final class Money
{
    /**
     * The scale used in BCMath calculations
     */
    const SCALE = 12;

    /**
     * The money amount
     *
     * @var string
     */
    protected $amount;

    /**
     * ISO currency
     *
     * @var string
     */
    protected $currency;

    /**
     * @param string $amount Amount, expressed as a string (eg '10.00')
     * @param string $currency
     *
     * @throws InvalidArgumentException If amount is not a numeric string value
     */
    public function __construct($amount, $currency)
    {
        $this->amount = (string) $amount;
        $this->currency = $currency;
    }

    /**
     * Returns the value represented by this Money object
     *
     * @return string
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * Returns the currency of this Money object
     *
     * @return string
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * Returns a new Money object that represents
     * the sum of this and another Money object
     *
     * @param Money $addend
     *
     * @return Money
     */
    public function add(Money $addend)
    {
        $this->assertSameCurrencyAs($addend);
        $amount = bcadd($this->amount, $addend->amount, self::SCALE);
        return new Money($amount, $this->currency);
    }

    /**
     * Returns a new Money object that represents
     * the difference of this and another Money object
     *
     * @param Money $subtrahend
     *
     * @return Money
     */
    public function subtract(Money $subtrahend)
    {
        $this->assertSameCurrencyAs($subtrahend);
        $amount = bcsub($this->amount, $subtrahend->amount, self::SCALE);
        return new Money($amount, $this->currency);
    }

    /**
     * Returns a new Money object that represents
     * the multiplied value by the given factor
     *
     * @param string $multiplier
     *
     * @return Money
     */
    public function multiply($multiplier)
    {
        $amount = bcmul($this->amount, (string) $multiplier, self::SCALE);
        return new Money($amount, $this->currency);
    }

    /**
     * Returns a new Money object that represents
     * the divided value by the given factor
     *
     * @param string $divisor
     *
     * @return Money
     * @throws InvalidArgumentException In case divisor is zero.
     */
    public function divide($divisor)
    {
        $amount = bcdiv($this->amount, (string) $divisor, self::SCALE);
        return new Money($amount, $this->currency);
    }

    /**
     * Rounds this Money to another scale
     *
     * @param integer $scale
     *
     * @return Money
     */
    public function round($scale = null)
    {
        if ($scale === null) {
            $scale = $this->currency === 'BTC' ? 8 : 2;
        }

        $add = '0.' . str_repeat('0', $scale) . '5';
        $amount = bcadd($this->amount, $add, $scale);
        return new Money($amount, $this->currency);
    }

    /**
     * Truncate this Money to another scale
     *
     * @param integer $scale
     *
     * @return Money
     */
    public function truncate($scale = null )
    {
        if ($scale === null) {
            $scale = $this->currency === 'BTC' ? 8 : 2;
        }

        $add = '0.' . str_repeat('0', $scale + 1) . '5';
        $amount = bcadd($this->amount, $add, $scale);
        return new Money($amount, $this->currency);
    }

    public function percent($percent)
    {
        return $this->multiply($percent)->divide('100');
    }

    /**
     * Checks whether the value represented by this object equals to the other
     *
     * @param Money $other
     *
     * @return boolean
     */
    public function equals(Money $other)
    {
        return $this->compare($other) === 0;
    }

    /**
     * Checks whether the value represented by this object is greater than the other
     *
     * @param Money $other
     *
     * @return boolean
     */
    public function gt(Money $other)
    {
        return $this->compare($other) === 1;
    }

    /**
     * @param Money $other
     *
     * @return bool
     */
    public function gte(Money $other)
    {
        return $this->compare($other) >= 0;
    }

    /**
     * Checks whether the value represented by this object is less than the other
     *
     * @param Money $other
     *
     * @return boolean
     */
    public function lt(Money $other)
    {
        return $this->compare($other) === -1;
    }

    /**
     * @param Money $other
     *
     * @return bool
     */
    public function lte(Money $other)
    {
        return $this->compare($other) <= 0;
    }

    /**
     * Checks if the value represented by this object is zero
     *
     * @return boolean
     */
    public function isZero()
    {
        return $this->compare0() === 0;
    }

    /**
     * Checks if the value represented by this object is positive
     *
     * @return boolean
     */
    public function isPositive()
    {
        return $this->compare0() === 1;
    }

    /**
     * Checks if the value represented by this object is negative
     *
     * @return boolean
     */
    public function isNegative()
    {
        return $this->compare0() === -1;
    }

    /**
     * Checks whether a Money has the same Currency as this
     *
     * @param Money $other
     *
     * @return boolean
     */
    public function sameCurrency(Money $other)
    {
        return $this->currency === $other->currency;
    }

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than the other
     *
     * @param Money $other
     *
     * @return int
     */
    private function compare(Money $other)
    {
        $this->assertSameCurrencyAs($other);
        return bccomp($this->amount, $other->amount, self::SCALE);
    }

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than 0
     *
     * @param Money $other
     *
     * @return int
     */
    private function compare0()
    {
        return bccomp($this->amount, '', self::SCALE);
    }

    /**
     * Asserts that a Money has the same currency as this
     *
     * @param Money $other
     *
     * @throws InvalidArgumentException If $other has a different currency
     */
    private function assertSameCurrencyAs(Money $other)
    {
        if (!$this->sameCurrency($other)) {
            throw new InvalidArgumentException('Currencies must be identical');
        }
    }

    function __toString()
    {
        return $this->round()->amount();
    }
}