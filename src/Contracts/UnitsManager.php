<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  UnitsManager
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface UnitsManager
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Create the distance unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function distance();

    /**
     * Create the liquid volume unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function liquidVolume();

    /**
     * Create the weight unit instance.
     *
     * @return \Arcanedev\Units\Bases\UnitMeasure
     */
    public function weight();
}
