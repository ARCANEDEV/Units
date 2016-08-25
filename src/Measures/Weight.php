<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Measures\Weight as WeightContract;
use Arcanedev\Units\Traits\Calculatable;

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
        $this->init($value, $unit, $options);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the default names.
     *
     * @return array
     */
    public function defaultNames()
    {
        return array_combine(static::units(), [
            'ton',
            'kilogram',
            'gram',
            'milligram',
        ]);
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
     * @return static
     */
    public static function make($value = 0, $unit = self::KG, array $options = [])
    {
        return parent::make($value, $unit, $options);
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
     * @return self
     */
    public function addWeight($value, $unit = self::KG)
    {
        return $this->add(static::make($value, $unit));
    }

    /**
     * Sub the weight.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return self
     */
    public function subWeight($value, $unit = self::KG)
    {
        return $this->sub(static::make($value, $unit));
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
