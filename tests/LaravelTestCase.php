<?php namespace Arcanedev\Units\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

/**
 * Class     LaravelTestCase
 *
 * @package  Arcanedev\Units\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class LaravelTestCase extends BaseTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->loadDeferredProviders();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Laravel Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function getPackageProviders($app)
    {
        return [
            \Arcanedev\Units\UnitsServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            \Arcanedev\Units\Facades\Unit::class,
        ];
    }


    protected function getEnvironmentSetUp($app)
    {
        //
    }
}
