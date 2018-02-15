<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Measures\LiquidVolume as LiquidVolumeContract;
use Arcanedev\Units\Traits\Calculatable;

/**
 * Class     LiquidVolume
 *
 * @package  Arcanedev\Units\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LiquidVolume extends UnitMeasure implements LiquidVolumeContract
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
     * Volume constructor.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     */
    public function __construct($value = 0, $unit = self::L, array $options = [])
    {
        parent::__construct($value, $unit, $options);
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
            'kilolitre',
            'hectolitre',
            'decalitre',
            'litre',
            'decilitre',
            'centilitre',
            'millilitre',
        ]);
    }

    /* -----------------------------------------------------------------
     |  Main Functions
     | -----------------------------------------------------------------
     */

    /**
     * Make a volume instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume|\Arcanedev\Units\Contracts\UnitMeasure
     */
    public static function make($value = 0, $unit = self::L, array $options = [])
    {
        return parent::make($value, $unit, $options);
    }

    /* -----------------------------------------------------------------
     |  Calculation Methods
     | -----------------------------------------------------------------
     */

    /**
     * Add the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume|\Arcanedev\Units\Contracts\UnitMeasure
     */
    public function addVolume($value, $unit = self::L)
    {
        return $this->add(static::make($value, $unit));
    }

    /**
     * Sub the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume|\Arcanedev\Units\Contracts\UnitMeasure
     */
    public function subVolume($value, $unit = self::L)
    {
        return $this->sub(static::make($value, $unit));
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the volume convert ratio.
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
     * Get all the volume ratios.
     *
     * @return array
     */
    protected static function getRatios()
    {
        $rate   = 10;
        $ratios = [
            static::KL  => 0,
            static::HL  => 1,
            static::DAL => 2,
            static::L   => 3,
            static::DL  => 4,
            static::CL  => 5,
            static::ML  => 6,
        ];

        return array_map(function ($ratio) use ($rate) {
            return static::calculate($rate, '^', $ratio);
        }, $ratios);
    }
}
