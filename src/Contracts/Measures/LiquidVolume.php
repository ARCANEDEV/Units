<?php namespace Arcanedev\Units\Contracts\Measures;

use Arcanedev\Units\Contracts\Traits\Calculatable;
use Arcanedev\Units\Contracts\UnitMeasure;

/**
 * Interface  LiquidVolume
 *
 * @package   Arcanedev\Units\Contracts\Measures
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface LiquidVolume extends UnitMeasure, Calculatable
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const KL  = 'kl';
    const HL  = 'hl';
    const DAL = 'dal';
    const L   = 'l';
    const DL  = 'dl';
    const CL  = 'cl';
    const ML  = 'ml';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a volume instance.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public static function make($value = 0, $unit = self::L, array $options = []);

    /**
     * Format the volume with symbol.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function formatWithSymbol($decimals = null, $decimalSeparator = null, $thousandsSeparator = null);

    /**
     * Format the volume.
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
     * Add the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public function addVolume($value, $unit = self::L);

    /**
     * Sub the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public function subVolume($value, $unit = self::L);
}
