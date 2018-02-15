<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  UnitMeasure
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface UnitMeasure
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the unit value.
     *
     * @return float|int
     */
    public function value();

    /**
     * Set the unit value.
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
     * Get the unit key.
     *
     * @return string
     */
    public function unit();

    /**
     * Set the unit key.
     *
     * @param  string  $unit
     *
     * @return static
     */
    public function setUnit($unit);

    /**
     * Get the unit symbols.
     *
     * @return array
     */
    public function symbols();

    /**
     * Set the unit symbols.
     *
     * @param  array  $symbols
     *
     * @return static
     */
    public function setSymbols(array $symbols);

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
     * Get the unit names.
     *
     * @return array
     */
    public function names();

    /**
     * Set the unit names.
     *
     * @param  array  $names
     *
     * @return static
     */
    public function setNames(array $names);

    /**
     * Get the unit name.
     *
     * @return string
     */
    public function name();

    /**
     * Get the name by a given unit.
     *
     * @param  string  $unit
     *
     * @return string
     */
    public function getName($unit);

    /**
     * Set the unit name.
     *
     * @param  string  $unit
     * @param  string  $name
     *
     * @return static
     */
    public function setName($unit, $name);

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
     * Convert the unit to the given unit key.
     *
     * @param  string  $to
     *
     * @return static
     */
    public function to($to);

    /**
     * Convert the unit.
     *
     * @param  string     $from
     * @param  string     $to
     * @param  float|int  $value
     *
     * @return float|int
     */
    public static function convert($from, $to, $value);
}
