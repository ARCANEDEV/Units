<?php namespace Arcanedev\Units\Bases;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Class     UnitMeasure
 *
 * @package  Arcanedev\Units\Base
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UnitMeasure
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The unit.
     *
     * @var string
     */
    protected $unit;

    /**
     * The value.
     *
     * @var float|int
     */
    protected $value;

    /**
     * The symbols.
     *
     * @var array
     */
    protected $symbols  = [];

    /**
     * The number of decimals to format.
     *
     * @var int
     */
    protected $decimals = 0;

    /**
     * The decimal separator.
     *
     * @var string
     */
    protected $decimalSeparator = '.';

    /**
     * The thousands separator.
     *
     * @var string
     */
    protected $thousandsSeparator = ',';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the weight value.
     *
     * @return float|int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the weight value.
     *
     * @param  float|int  $value
     *
     * @return static
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the default units.
     *
     * @return array
     */
    public static function units()
    {
        $constants = (new ReflectionClass(get_called_class()))
            ->getConstants();

        return array_values($constants);
    }

    /**
     * Get the weight unit.
     *
     * @return string
     */
    public function unit()
    {
        return $this->unit;
    }

    /**
     * Set the weight unit.
     *
     * @param  string  $unit
     *
     * @return static
     */
    public function setUnit($unit)
    {
        static::checkUnit($unit);

        $this->unit = $unit;

        return $this;
    }

    /**
     * Get the available units.
     *
     * @return array
     */
    public function symbols()
    {
        return $this->symbols;
    }

    /**
     * Get the symbol.
     *
     * @return string
     */
    public function symbol()
    {
        return Arr::get($this->symbols(), $this->unit);
    }

    /**
     * Set the unit symbol.
     *
     * @param  string  $unit
     * @param  string  $symbol
     *
     * @return static
     */
    public function setSymbol($unit, $symbol)
    {
        static::checkUnit($unit);

        $this->symbols[$unit] = $symbol;

        return $this;
    }

    /**
     * Get the default symbols.
     *
     * @return array
     */
    protected static function defaultSymbols()
    {
        return array_combine(static::units(), static::units());
    }

    /**
     * Set the symbols.
     *
     * @param  array  $symbols
     *
     * @return static
     */
    public function setSymbols(array $symbols)
    {
        if (empty($symbols)) $symbols = static::defaultSymbols();

        foreach ($symbols as $unit => $symbol) {
            $this->setSymbol($unit, $symbol);
        }

        return $this;
    }

    /**
     * Set the format.
     *
     * @param  int     $decimals
     * @param  string  $decimalSeparator
     * @param  string  $thousandsSeparator
     *
     * @return static
     */
    public function setFormat($decimals = 0, $decimalSeparator = ',', $thousandsSeparator = '.')
    {
        $this->decimals           = $decimals;
        $this->decimalSeparator   = $decimalSeparator;
        $this->thousandsSeparator = $thousandsSeparator;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Format the weight.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function format(
        $decimals = null,
        $decimalSeparator = null,
        $thousandsSeparator = null
    ) {
        return number_format($this->value(),
            is_null($decimals)           ? $this->decimals           : $decimals,
            is_null($decimalSeparator)   ? $this->decimalSeparator   : $decimalSeparator,
            is_null($thousandsSeparator) ? $this->thousandsSeparator : $thousandsSeparator
        );
    }

    /**
     * Format the weight with symbol.
     *
     * @param  int|null     $decimals
     * @param  string|null  $decimalSeparator
     * @param  string|null  $thousandsSeparator
     *
     * @return string
     */
    public function formatWithSymbol(
        $decimals = null,
        $decimalSeparator = null,
        $thousandsSeparator = null
    ) {
        return $this->format($decimals, $decimalSeparator, $thousandsSeparator).' '.$this->symbol();
    }

    /**
     * Convert object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->formatWithSymbol();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check the weight unit.
     *
     * @param  string  $unit
     */
    protected static function checkUnit($unit)
    {
        if ( ! in_array($unit, static::units())) {
            throw new InvalidArgumentException(
                "The weight unit [{$unit}] is invalid."
            );
        }
    }
}
