<?php namespace Arcanedev\Units;

use Arcanedev\Units\Contracts\UnitsManager as UnitsManagerContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
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
    public function createDistanceDriver()
    {
        return $this->buildUnit('distance', Measures\Distance::class);
    }

    /**
     * Create the liquid volume unit instance.
     *
     * @return Bases\UnitMeasure
     */
    public function createLiquidVolumeDriver()
    {
        return $this->buildUnit('liquid-volume', Measures\LiquidVolume::class);
    }

    /**
     * Create the weight unit instance.
     *
     * @return Bases\UnitMeasure
     */
    public function createWeightDriver()
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create a new driver instance.
     *
     * @param  string  $driver
     *
     * @return mixed
     */
    protected function createDriver($driver)
    {
        $method = 'create'.Str::studly($driver).'Driver';

        // We'll check to see if a creator method exists for the given driver. If not we
        // will check for a custom driver creator, which allows developers to create
        // drivers using their own customized driver creator Closure to create it.
        if (isset($this->customCreators[$driver]))
            return $this->callCustomCreator($driver);
        elseif (method_exists($this, $method))
            return $this->$method();

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

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
