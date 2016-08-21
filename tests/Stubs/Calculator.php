<?php namespace Arcanedev\Units\Tests\Stubs;

use Arcanedev\Units\Traits\Calculatable;

/**
 * Class     Calculator
 *
 * @package  Arcanedev\Units\Tests\Stubs
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Calculator
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Calculatable;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public static function add($a, $b)
    {
        return static::calculate($a, '+', $b);
    }

    public static function sub($a, $b)
    {
        return static::calculate($a, '-', $b);
    }

    public static function multiply($a, $b)
    {
        return static::calculate($a, 'x', $b);
    }

    public static function divide($a, $b)
    {
        return static::calculate($a, '/', $b);
    }

    public static function pow($a, $b)
    {
        return static::calculate($a, '^', $b);
    }

    public static function dummy($a, $b)
    {
        return static::calculate($a, null, $b);
    }
}
