<?php namespace Arcanedev\Units\Traits;

/**
 * Trait     Calculatable
 *
 * @package  Arcanedev\Units\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
trait Calculatable
{
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
        switch ($operator) {
            case '+':
                return $a + $b;

            case '-':
                return $a - $b;

            case 'x':
            case '*':
                return $a * $b;

            case '/':
                return $a / $b;

            case '^':
                return pow($a, $b);
        }

        return $a;
    }
}
