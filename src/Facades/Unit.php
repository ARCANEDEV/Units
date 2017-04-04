<?php namespace Arcanedev\Units\Facades;

use Arcanedev\Units\Contracts\UnitsManager;
use Illuminate\Support\Facades\Facade;

/**
 * Class     Unit
 *
 * @package  Arcanedev\Units\Facades
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Unit extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return UnitsManager::class; }
}
