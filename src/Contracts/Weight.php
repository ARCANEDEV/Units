<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  Weight
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Weight extends UnitMeasure
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
