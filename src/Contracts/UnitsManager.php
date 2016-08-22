<?php namespace Arcanedev\Units\Contracts;

/**
 * Interface  UnitsManager
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface UnitsManager
{
    /**
     * Get an unit of measure implementation.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function driver($driver = null);
}
