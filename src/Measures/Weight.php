<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Weight as WeightContract;
use Arcanedev\Units\Traits\Calculatable;
use Illuminate\Support\Arr;

/**
 * Class     Weight
 *
 * @package  Arcanedev\Units
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Weight extends UnitMeasure implements WeightContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Calculatable;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Weight constructor.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
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

        return Arr::get(static::names(), $unit);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make a weight instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
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

    /* ------------------------------------------------------------------------------------------------
     |  Calculation Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add the weight.
     *
     * @param  float|int  $value
     * @param  string     $unit
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
     * @param  float|int  $value
     * @param  string     $unit
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
     * @param  float|int  $number
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
     * @param  float|int  $number
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
        $rate   = 1000;
        $ratios = [
            static::TON => 0,
            static::KG  => 1,
            static::G   => 2,
            static::MG  => 3,
        ];

        return array_map(function ($ratio) use ($rate) {
            return static::calculate($rate, '^', $ratio);
        }, $ratios);
    }
}
