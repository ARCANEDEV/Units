<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Traits\Calculatable;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Arcanedev\Units\Contracts\Weight as WeightContract;

/**
 * Class     Weight
 *
 * @package  Arcanedev\Units
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Weight implements WeightContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Calculatable;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The weight unit.
     *
     * @var string
     */
    protected $unit;

    /**
     * The weight value.
     *
     * @var double|float|integer
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
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Weight constructor.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     * @param  array                 $options
     */
    public function __construct($value = 0, $unit = self::KG, array $options = [])
    {
        $this->setValue($value);
        $this->setUnit($unit);
        $this->setSymbols(Arr::get($options, 'symbols', []));
        $this->setFormat(
            Arr::get($options, 'decimals', 0),
            Arr::get($options, 'separators.decimal', ','),
            Arr::get($options, 'separators.thousands', '.')
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the weight value.
     *
     * @return double|float|integer
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Set the weight value.
     *
     * @param  double|float|integer  $value
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
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
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setUnit($unit)
    {
        static::checkUnit($unit);

        $this->unit = $unit;

        return $this;
    }

    /**
     * Get the default units.
     *
     * @return array
     */
    public static function units()
    {
        return [
            self::TON,
            self::KG,
            self::G,
            self::MG,
        ];
    }

    /**
     * Get the symbol's names.
     *
     * @return array
     */
    public static function names()
    {
        return array_combine(static::units(), [
            'ton',
            'kilogram',
            'gram',
            'milligram',
        ]);
    }

    /**
     * Get the symbol name.
     *
     * @param  string  $unit
     *
     * @return string
     */
    public static function getSymbolName($unit)
    {
        static::checkUnit($unit);

        return static::names()[$unit];
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
     * Get the available units.
     *
     * @return array
     */
    public function symbols()
    {
        return $this->symbols;
    }

    /**
     * Set the symbols.
     *
     * @param  array  $symbols
     *
     * @return \Arcanedev\Units\Contracts\Weight
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
     * Get the symbol.
     *
     * @return string
     */
    public function symbol()
    {
        return $this->symbols[$this->unit];
    }

    /**
     * Set the unit symbol.
     *
     * @param  string  $unit
     * @param  string  $symbol
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function setSymbol($unit, $symbol)
    {
        static::checkUnit($unit);

        $this->symbols[$unit] = $symbol;

        return $this;
    }

    /**
     * Set the format.
     *
     * @param  int     $decimals
     * @param  string  $decimalSeparator
     * @param  string  $thousandsSeparator
     *
     * @return \Arcanedev\Units\Contracts\Weight
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
     * Make a weight instance.
     *
     * @param  integer|float|double  $value
     * @param  string                $unit
     * @param  array                 $options
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public static function make($value = 0, $unit = self::KG, array $options = [])
    {
        return new static($value, $unit, $options);
    }

    /**
     * Convert the weight to the given unit.
     *
     * @param  string  $to
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function to($to)
    {
        if ($to === $this->unit()) return $this;

        $value = static::convert($this->unit(), $to, $this->value());

        return static::make($value, $to);
    }

    /**
     * Convert the weight.
     *
     * @param  string                $from
     * @param  string                $to
     * @param  double|float|integer  $value
     *
     * @return double|float|integer
     */
    public static function convert($from, $to, $value)
    {
        return $value * static::getRatio($to, $from);
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
        return number_format($this->value,
            is_null($decimals)           ? $this->decimals           : $decimals,
            is_null($decimalSeparator)   ? $this->decimalSeparator   : $decimalSeparator,
            is_null($thousandsSeparator) ? $this->thousandsSeparator : $thousandsSeparator
        );
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
    public function addWeight($value, $unit = self::KG)
    {
        return $this->add(
            self::make($value, $unit)
        );
    }

    /**
     * Add the weight instance.
     *
     * @param  \Arcanedev\Units\Contracts\Weight  $weight
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function add(WeightContract $weight)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '+', $weight->to($this->unit())->value()
            )
        );
    }

    /**
     * Sub the weight.
     *
     * @param  double|float|integer  $value
     * @param  string                $unit
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function subWeight($value, $unit = self::KG)
    {
        return $this->sub(
            static::make($value, $unit)
        );
    }

    /**
     * Sub the weight instance.
     *
     * @param  \Arcanedev\Units\Contracts\Weight  $weight
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function sub(WeightContract $weight)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '-', $weight->to($this->unit())->value()
            )
        );
    }

    /**
     * Multiply weight by the given number.
     *
     * @param  integer|double|float  $number
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function multiply($number)
    {
        return $this->setValue(
            static::calculate($this->value(), 'x', $number)
        );
    }

    /**
     * Divide weight by the given number.
     *
     * @param  integer|double|float  $number
     *
     * @return \Arcanedev\Units\Contracts\Weight
     */
    public function divide($number)
    {
        return $this->setValue(
            static::calculate($this->value(), '/', $number)
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the weight convert ratio.
     *
     * @param  string  $to
     * @param  string  $from
     *
     * @return double|float|integer
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
     * Get all the weight ratios.
     *
     * @return array
     */
    protected static function getRatios()
    {
        $ratios = [
            static::TON => 0,
            static::KG  => 1,
            static::G   => 2,
            static::MG  => 3,
        ];

        return array_map(function ($ratio) {
            return static::calculate(1000, '^', $ratio);
        }, $ratios);
    }

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
