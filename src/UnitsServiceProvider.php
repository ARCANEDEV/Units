<?php namespace Arcanedev\Units;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     UnitsServiceProvider
 *
 * @package  Arcanedev\Units
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsServiceProvider extends PackageServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * Package name.
     *
     * @var string
     */
    protected $package = 'units';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerConfig();
        $this->registerManager();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->publishConfig();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Contracts\UnitsManager::class,
        ];
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Register the Units Manager.
     */
    private function registerManager()
    {
        $this->singleton(Contracts\UnitsManager::class, function ($app) {
            return new UnitsManager($app);
        });
    }
}
