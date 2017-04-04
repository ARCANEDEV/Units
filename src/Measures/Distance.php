<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Measures\Distance as DistanceContract;
use Arcanedev\Units\Traits\Calculatable;

/**
 * Class     Distance
 *
 * @package  Arcanedev\Units\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Distance extends UnitMeasure implements DistanceContract
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */
    use Calculatable;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
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
        $this->init($value, $unit, $options);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the default names.
     *
     * @return array
     */
    public function defaultNames()
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

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
    public static function make($value = 0, $unit = self::M, array $options = [])
    {
        return parent::make($value, $unit, $options);
    }

    /* -----------------------------------------------------------------
     |  Calculation Methods
     | -----------------------------------------------------------------
     */
    /**
     * Add the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Distance
     */
    public function addDistance($value, $unit = self::M)
    {
        return $this->add(static::make($value, $unit));
    }

    /**
     * Sub the distance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\Distance
     */
    public function subDistance($value, $unit = self::M)
    {
        return $this->sub(static::make($value, $unit));
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get all the distance ratios.
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
