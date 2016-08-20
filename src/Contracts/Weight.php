<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  Weight
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Weight
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const TON = 't';
    const KG  = 'kg';
    const G   = 'g';
    const MG  = 'mg';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the weight value.
     *
     * @return double|float|integer
     */
    public function value();

    /**
     * Set the weight value.
     *
     * @param  double|float|integer  $value
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setValue($value);

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
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setUnit($unit);

    /**
     * Get the default units.
     *
     * @return array
     */
    public static function units();

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

    /**
     * Get the available units.
     *
     * @return array
     */
    public function symbols();

    /**
     * Set the symbols.
     *
     * @param  array  $symbols
     *
     * @return \Arcanedev\Units\Contracts\Weight
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
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setSymbol($unit, $symbol);

    /**
     * Set the format.
     *
     * @param  int     $decimals
     * @param  string  $decimalSeparator
     * @param  string  $thousandsSeparator
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setFormat($decimals = 0, $decimalSeparator = ',', $thousandsSeparator = '.');

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a weight instance.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public static function make($value = 0, $unit = self::KG, array $options = []);

    /**
     * Convert the weight to the given unit.
     *
     * @param  string  $to
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function to($to);

    /**
     * Convert the weight.
     *
     * @param  string                $from
     * @param  string                $to
     * @param  double|float|integer  $value
     *
     * @return double|float|integer
     */
    public static function convert($from, $to, $value);

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

    /* ------------------------------------------------------------------------------------------------
     |  Calculation Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add the weight.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function addWeight($value, $unit = self::KG);

    /**
     * Add the weight instance.
     *
     * @param  \Arcanedev\Units\Contracts\Weight  $weight
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function add(self $weight);

    /**
     * Sub the weight.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function subWeight($value, $unit = self::KG);

    /**
     * Sub the weight instance.
     *
     * @param  \Arcanedev\Units\Contracts\Weight  $weight
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function sub(self $weight);

    /**
     * Multiply weight by the given number.
     *
     * @param  integer|double|float  $number
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function multiply($number);

    /**
     * Divide weight by the given number.
     *
     * @param  integer|double|float  $number
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function divide($number);
}
