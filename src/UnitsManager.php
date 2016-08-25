<?php namespace Arcanedev\Units;

use Arcanedev\Support\Manager;
use Arcanedev\Units\Contracts\UnitsManager as UnitsManagerContract;
use Illuminate\Support\Arr;
use InvalidArgumentException;

/**
 * Class     UnitsManager
 *
 * @package  Arcanedev\Units
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsManager extends Manager implements UnitsManagerContract
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create the distance unit instance.
     *
     * @return Bases\UnitMeasure
     */
    public function distance()
    {
        return $this->buildUnit('distance', Measures\Distance::class);
    }

    /**
     * Create the liquid volume unit instance.
     *
     * @return Bases\UnitMeasure
     */
    public function liquidVolume()
    {
        return $this->buildUnit('liquid-volume', Measures\LiquidVolume::class);
    }

    /**
     * Create the weight unit instance.
     *
     * @return Bases\UnitMeasure
     */
    public function weight()
    {
        return $this->buildUnit('weight', Measures\Weight::class);
    }

    /**
     * Create the distance unit driver.
     *
     * @return Bases\UnitMeasure
     */
    protected function createDistanceDriver()
    {
        return $this->distance();
    }

    /**
     * Create the liquid volume unit driver.
     *
     * @return Bases\UnitMeasure
     */
    protected function createLiquidVolumeDriver()
    {
        return $this->liquidVolume();
    }

    /**
     * Create the weight unit driver.
     *
     * @return Bases\UnitMeasure
     */
    protected function createWeightDriver()
    {
        return $this->weight();
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
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
