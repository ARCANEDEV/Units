<?php namespace Arcanedev\Units\Traits;

use Arcanedev\Units\Contracts\UnitMeasure;

/**
 * Trait     Calculatable
 *
 * @package  Arcanedev\Units\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait Calculatable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add the unit instance.
     *
     * @param  \Arcanedev\Units\Contracts\UnitMeasure  $unit
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function add(UnitMeasure $unit)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '+', $unit->to($this->unit())->value()
            )
        );
    }

    /**
     * Sub the unit instance.
     *
     * @param  \Arcanedev\Units\Contracts\UnitMeasure  $unit
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function sub(UnitMeasure $unit)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '-', $unit->to($this->unit())->value()
            )
        );
    }

    /**
     * Multiply unit by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function multiply($number)
    {
        return $this->setValue(
            static::calculate($this->value(), 'x', $number)
        );
    }

    /**
     * Divide unit by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\Measures\Weight
     */
    public function divide($number)
    {
        return $this->setValue(
            static::calculate($this->value(), '/', $number)
        );
    }

    /**
     * Calculate the value.
     *
     * @param  float|int  $a
     * @param  string     $operator
     * @param  float|int  $b
     *
     * @return float|int
     */
    protected static function calculate($a, $operator, $b)
    {
        $operations = $operations = [
            '+' => function ($a, $b) { return $a + $b; },
            '-' => function ($a, $b) { return $a - $b; },
            'x' => function ($a, $b) { return $a * $b; },
            '*' => function ($a, $b) { return $a * $b; },
            '/' => function ($a, $b) { return $a / $b; },
            '^' => function ($a, $b) { return pow($a, $b); },
        ];

        return array_key_exists($operator, $operations)
            ? call_user_func_array($operations[$operator], [$a, $b])
            : $a;
    }
}
