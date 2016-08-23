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
