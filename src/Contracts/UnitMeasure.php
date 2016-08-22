<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  UnitMeasure
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface UnitMeasure
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the weight value.
     *
     * @return float|int
     */
    public function value();

    /**
     * Set the weight value.
     *
     * @param  float|int  $value
     *
     * @return static
     */
    public function setValue($value);

    /**
     * Get the default units.
     *
     * @return array
     */
    public static function units();

    /**
     * Get the weight unit.
     *
     * @return string
     */
    public function unit();

    /**
     * Set the weight unit.
     *
     * @param  string  $unit
     *
     * @return static
     */
    public function setUnit($unit);

    /**
     * Get the available units.
     *
     * @return array
     */
    public function symbols();

    /**
     * Get the symbol.
     *
     * @return string
     */
    public function symbol();

    /**
     * Set the unit symbol.
     *
     * @param  string  $unit
     * @param  string  $symbol
     *
     * @return static
     */
    public function setSymbol($unit, $symbol);

    /**
     * Set the symbols.
     *
     * @param  array  $symbols
     *
     * @return static
     */
    public function setSymbols(array $symbols);

    /**
     * Set the format.
     *
     * @param  int     $decimals
     * @param  string  $decimalSeparator
     * @param  string  $thousandsSeparator
     *
     * @return static
     */
    public function setFormat($decimals = 0, $decimalSeparator = ',', $thousandsSeparator = '.');

    /**
     * Convert the unit object to the given unit of measure.
     *
     * @param  string  $to
     *
     * @return static
     */
    public function to($to);
}
