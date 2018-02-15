<?php namespace Arcanedev\Units\Contracts\Measures;

use Arcanedev\Units\Contracts\Traits\Calculatable;
use Arcanedev\Units\Contracts\UnitMeasure;

/**
 * Interface  Weight
 *
 * @package   Arcanedev\Units\Contracts\Measures
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Weight extends UnitMeasure, Calculatable
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const TON = 't';
    const KG  = 'kg';
    const G   = 'g';
    const MG  = 'mg';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Make a weight instance.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\Measures\Weight
     */
    public static function make($value = 0, $unit = self::KG, array $options = []);

    /**
     * Format the weight with symbol.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function formatWithSymbol($decimals = null, $decimalSeparator = null, $thousandsSeparator = null);

    /**
     * Format the weight.
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
     * Add the weight.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Weight
     */
    public function addWeight($value, $unit = self::KG);

    /**
     * Sub the weight.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Weight
     */
    public function subWeight($value, $unit = self::KG);
}
