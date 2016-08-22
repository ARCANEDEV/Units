<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  LiquidVolume
 *
 * @package   Arcanedev\Units\Contracts
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
     * Make a volume instance.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\LiquidVolume
     */
    public static function make($value = 0, $unit = self::L, array $options = []);

    /**
     * Convert the volume.
     *
     * @param  string                $from
     * @param  string                $to
     * @param  double|float|integer  $value
     *
     * @return double|float|integer
     */
    public static function convert($from, $to, $value);

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
     * @return \Arcanedev\Units\Contracts\LiquidVolume
     */
    public function addVolume($value, $unit = self::L);

    /**
     * Sub the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\LiquidVolume
     */
    public function subVolume($value, $unit = self::L);
}
