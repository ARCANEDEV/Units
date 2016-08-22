<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Distance as DistanceContract;
use Arcanedev\Units\Traits\Calculatable;
use Illuminate\Support\Arr;

/**
 * Class     Distance
 *
 * @package  Arcanedev\Units\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Distance extends UnitMeasure implements DistanceContract
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
     * Distance constructor.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     */
    public function __construct($value = 0, $unit = self::M, array $options = [])
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
            'kilometer',
            'hectometre',
            'decametre',
            'metre',
            'decimetre',
            'centimetre',
            'millimetre',
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
     * Make a distance instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public static function make($value = 0, $unit = self::M, array $options = [])
    {
        return new static($value, $unit, $options);
    }

    /**
     * Convert the weight to the given unit.
     *
     * @param  string  $to
     *
     * @return \Arcanedev\Units\Contracts\Distance
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
     * Add the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function addDistance($value, $unit = self::M)
    {
        return $this->add(
            self::make($value, $unit)
        );
    }

    /**
     * Add the distance instance.
     *
     * @param  \Arcanedev\Units\Contracts\Distance  $distance
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function add(DistanceContract $distance)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '+', $distance->to($this->unit())->value()
            )
        );
    }

    /**
     * Sub the weight.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function subDistance($value, $unit = self::M)
    {
        return $this->sub(
            static::make($value, $unit)
        );
    }

    /**
     * Sub the distance instance.
     *
     * @param  \Arcanedev\Units\Contracts\Distance  $distance
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function sub(DistanceContract $distance)
    {
        return $this->setValue(
            static::calculate(
                $this->value(), '-', $distance->to($this->unit())->value()
            )
        );
    }

    /**
     * Multiply distance by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\Distance
     */
    public function multiply($number)
    {
        return $this->setValue(
            static::calculate($this->value(), 'x', $number)
        );
    }

    /**
     * Divide distance by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\Distance
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
        $rate   = 10;
        $ratios = [
            static::KM  => 0,
            static::HM  => 1,
            static::DAM => 2,
            static::M   => 3,
            static::DM  => 4,
            static::CM  => 5,
            static::MM  => 6,
        ];

        return array_map(function ($ratio) use ($rate) {
            return static::calculate($rate, '^', $ratio);
        }, $ratios);
    }
}
