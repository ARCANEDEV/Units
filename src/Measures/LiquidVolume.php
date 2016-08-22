<?php namespace Arcanedev\Units\Measures;

use Arcanedev\Units\Bases\UnitMeasure;
use Arcanedev\Units\Contracts\Measures\LiquidVolume as LiquidVolumeContract;
use Arcanedev\Units\Traits\Calculatable;
use Illuminate\Support\Arr;

/**
 * Class     LiquidVolume
 *
 * @package  Arcanedev\Units\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LiquidVolume extends UnitMeasure implements LiquidVolumeContract
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
     * Volume constructor.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     */
    public function __construct($value = 0, $unit = self::L, array $options = [])
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
            'kilolitre',
            'hectolitre',
            'decalitre',
            'litre',
            'decilitre',
            'centilitre',
            'millilitre',
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
     * Make a volume instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public static function make($value = 0, $unit = self::L, array $options = [])
    {
        return new static($value, $unit, $options);
    }

    /**
     * Convert the volume to the given unit.
     *
     * @param  string  $to
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public function to($to)
    {
        if ($to === $this->unit()) return $this;

        $value = static::convert($this->unit(), $to, $this->value());

        return static::make($value, $to);
    }

    /**
     * Convert the volume.
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
     * Add the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public function addVolume($value, $unit = self::L)
    {
        return $this->add(
            self::make($value, $unit)
        );
    }

    /**
     * Sub the volume.
     *
     * @param  float|int  $value
     * @param  string     $unit
     *
     * @return \Arcanedev\Units\Contracts\Measures\LiquidVolume
     */
    public function subVolume($value, $unit = self::L)
    {
        return $this->sub(
            static::make($value, $unit)
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
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
