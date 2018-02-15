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
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const KM  = 'km';
    const HM  = 'hm';
    const DAM = 'dam';
    const M   = 'm';
    const DM  = 'dm';
    const CM  = 'cm';
    const MM  = 'mm';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make a distance instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     *
     * @return static
     */
    public static function make($value = 0, $unit = self::M, array $options = []);

    /**
     * Convert the distance.
     *
     * @param  string     $from
     * @param  string     $to
     * @param  float|int  $value
     *
     * @return float|int
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

    /* -----------------------------------------------------------------
     |  Calculation Methods
     | -----------------------------------------------------------------
     */

    /**
     * Add the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Distance
     */
    public function addDistance($value, $unit = self::M);

    /**
     * Sub the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Distance
     */
    public function subDistance($value, $unit = self::M);
}
