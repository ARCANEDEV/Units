<?php namespace Arcanedev\Units\Bases;

use Arcanedev\Units\Contracts\UnitMeasure as UnitMeasureContract;
use Arcanedev\Units\Exceptions\InvalidUnitException;
use Illuminate\Support\Arr;
use ReflectionClass;

/**
 * Class     UnitMeasure
 *
 * @package  Arcanedev\Units\Base
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class UnitMeasure implements UnitMeasureContract
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
     * The unit symbols.
     *
     * @var array
     */
    protected $symbols  = [];

    /**
     * The unit names.
     *
     * @var array
     */
    protected $names  = [];

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
     |  Init Functions
     | ------------------------------------------------------------------------------------------------
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
    public static function make($value = 0, $unit = null, array $options = [])
    {
        return new static($value, $unit, $options);
    }

    /**
     * Initialize the unit.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     */
    protected function init($value, $unit, array $options)
    {
        $this->setValue($value);
        $this->setUnit($unit);
        $this->setSymbols(Arr::get($options, 'symbols', []));
        $this->setNames(Arr::get($options, 'names', []));
        $this->setFormat(
            Arr::get($options, 'format.decimals', 0),
            Arr::get($options, 'format.decimal-separator', ','),
            Arr::get($options, 'format.thousands-separator', '.')
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the unit value.
     *
     * @return float|int
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the unit value.
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
     * Get the unit key.
     *
     * @return string
     */
    public function unit()
    {
        return $this->unit;
    }

    /**
     * Set the unit key.
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
     * Get the unit symbols.
     *
     * @return array
     */
    public function symbols()
    {
        return $this->symbols;
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
     * Set the unit symbols.
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
     * Get the unit symbol.
     *
     * @return string
     */
    public function symbol()
    {
        return Arr::get($this->symbols(), $this->unit());
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
     * Get the unit names.
     *
     * @return array
     */
    public function names()
    {
        return $this->names;
    }

    /**
     * Get the default names.
     *
     * @return array
     */
    abstract public function defaultNames();

    /**
     * Set the unit names.
     *
     * @param  array  $names
     *
     * @return static
     */
    public function setNames(array $names)
    {
        if (empty($names)) $names = $this->defaultNames();

        foreach ($names as $unit => $name) {
            $this->setName($unit, $name);
        }

        return $this;
    }

    /**
     * Get the unit name.
     *
     * @return string
     */
    public function name()
    {
        return $this->getName($this->unit());
    }

    /**
     * Get the name by a given unit.
     *
     * @param  string  $unit
     *
     * @return string
     */
    public function getName($unit)
    {
        static::checkUnit($unit);

        return Arr::get($this->names(), $unit);
    }

    /**
     * Set the unit name.
     *
     * @param  string  $unit
     * @param  string  $name
     *
     * @return static
     */
    public function setName($unit, $name)
    {
        static::checkUnit($unit);

        $this->names[$unit] = $name;

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
     * Convert the unit to the given unit key.
     *
     * @param  string  $to
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function to($to)
    {
        if ($to === $this->unit()) return $this;

        $value = static::convert($this->unit(), $to, $this->value());

        return static::make($value, $to, [
            'symbols' => $this->symbols(),
            'names'   => $this->names(),
            'format'  => [
                'decimals'            => $this->decimals,
                'decimal-separator'   => $this->decimalSeparator,
                'thousands-separator' => $this->thousandsSeparator,
            ],
        ]);
    }

    /**
     * Convert the unit.
     *
     * @param  string     $from
     * @param  string     $to
     * @param  float|int  $value
     *
     * @return float|int
     */
    public static function convert($from, $to, $value)
    {
        return $value * static::getRatio($to, $from);
    }

    /**
     * Format the unit.
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
     * Format the unit with symbol.
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
     * Get the unit ratio.
     *
     * @param  string  $to
     * @param  string  $from
     *
     * @return float|int
     */
    protected static function getRatio($to, $from)
    {
        static::checkUnit($from);
        static::checkUnit($to);

        if ($to === $from) return 1;

        $ratios = static::getRatios();

        return $ratios[$to] / $ratios[$from];
    }

    /**
     * Get all the unit ratios.
     *
     * @codeCoverageIgnore
     *
     * @return array
     */
    protected static function getRatios()
    {
        return [];
    }

    /**
     * Check the weight unit.
     *
     * @param  string  $unit
     */
    protected static function checkUnit($unit)
    {
        if ( ! in_array($unit, static::units())) {
            $class = static::class;

            throw new InvalidUnitException(
                "Invalid unit of measurement [{$unit}] in $class."
            );
        }
    }
}
