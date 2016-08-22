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
