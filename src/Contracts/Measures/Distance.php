<?php namespace Arcanedev\Units\Contracts\Measures;

use Arcanedev\Units\Contracts\Traits\Calculatable;
use Arcanedev\Units\Contracts\UnitMeasure;

/**
 * Interface  Distance
 *
 * @package   Arcanedev\Units\Contracts\Measures
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Distance extends UnitMeasure, Calculatable
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const KM  = 'km';
    const HM  = 'hm';
    const DAM = 'dam';
    const M   = 'm';
    const DM  = 'dm';
    const CM  = 'cm';
    const MM  = 'mm';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the symbol's names.
     *
     * @return array
     */
    public static function names();

    /**
     * Get the symbol name.
     *
     * @param  string  $unit
     *
     * @return string
     */
    public static function getSymbolName($unit);

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a distance instance.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public static function make($value = 0, $unit = self::M, array $options = []);

    /**
     * Convert the distance.
     *
     * @param  string                $from
     * @param  string                $to
     * @param  double|float|integer  $value
     *
     * @return double|float|integer
     */
    public static function convert($from, $to, $value);

    /**
     * Format the distance with symbol.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function formatWithSymbol($decimals = null, $decimalSeparator = null, $thousandsSeparator = null);

    /**
     * Format the distance.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function format($decimals = null, $decimalSeparator = null, $thousandsSeparator = null);

    /* ------------------------------------------------------------------------------------------------
     |  Calculation Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function addDistance($value, $unit = self::M);

    /**
     * Sub the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function subDistance($value, $unit = self::M);
}
