<?php namespace Arcanedev\Units;

use Arcanedev\Units\Contracts\UnitsManager as UnitsManagerContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use InvalidArgumentException;

/**
 * Class     UnitsManager
 *
 * @package  Arcanedev\Units
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsManager extends Manager implements UnitsManagerContract
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Create the distance unit driver.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    protected function createDistanceDriver()
    {
        return $this->distance();
    }

    /**
     * Create the distance unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function distance()
    {
        return $this->buildUnit('distance', Measures\Distance::class);
    }

    /**
     * Create the file size unit driver.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    protected function createFileSizeDriver()
    {
        return $this->fileSize();
    }

    /**
     * Create the file size unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function fileSize()
    {
        return $this->buildUnit('file-size', Measures\FileSize::class);
    }

    /**
     * Create the liquid volume unit driver.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    protected function createLiquidVolumeDriver()
    {
        return $this->liquidVolume();
    }

    /**
     * Create the liquid volume unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function liquidVolume()
    {
        return $this->buildUnit('liquid-volume', Measures\LiquidVolume::class);
    }

    /**
     * Create the weight unit driver.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    protected function createWeightDriver()
    {
        return $this->weight();
    }

    /**
     * Create the weight unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function weight()
    {
        return $this->buildUnit('weight', Measures\Weight::class);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        throw new InvalidArgumentException('No unit of measurement was specified.');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Build the unit of measurement.
     *
     * @param  string  $key
     * @param  string  $unitClass
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    protected function buildUnit($key, $unitClass)
    {
        $configs = $this->app['config']->get("units.$key", []);

        return new $unitClass(
            0, Arr::get($configs, 'default'), Arr::except($configs, ['default'])
        );
    }
}
