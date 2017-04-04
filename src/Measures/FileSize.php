<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Measures\FileSize as FileSizeContract;
use Arcanedev\Units\Traits\Calculatable;

/**
 * Class     FileSize
 *
 * @package  Arcanedev\Units\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FileSize extends UnitMeasure implements FileSizeContract
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */
    use Calculatable;

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
            'yotta',
            'zetta',
            'exa',
            'peta',
            'tera',
            'gigabyte',
            'megabyte',
            'kilobyte',
            'byte',
        ]);
    }

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
    public function __construct($value = 0, $unit = self::B, array $options = [])
    {
        $this->init($value, $unit, $options);
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
    public static function make($value = 0, $unit = self::B, array $options = [])
    {
        return parent::make($value, $unit, $options);
    }

    /* -----------------------------------------------------------------
     |  Calculation Methods
     | -----------------------------------------------------------------
     */
    /**
     * Add the file size.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\FileSize
     */
    public function addDistance($value, $unit = self::B)
    {
        return $this->add(static::make($value, $unit));
    }

    /**
     * Sub the file size.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\FileSize
     */
    public function subSize($value, $unit = self::B)
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
        $rate   = 1024;
        $ratios = [
            FileSize::YB => 0,
            FileSize::ZB => 1,
            FileSize::EB => 2,
            FileSize::PB => 3,
            FileSize::TB => 4,
            FileSize::GB => 5,
            FileSize::MB => 6,
            FileSize::KB => 7,
            FileSize::B  => 8,
        ];

        return array_map(function ($ratio) use ($rate) {
            return static::calculate($rate, '^', $ratio);
        }, $ratios);
    }
}
