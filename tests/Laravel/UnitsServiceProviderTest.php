<?php namespace Arcanedev\Units\Tests\Laravel;

use Arcanedev\Units\Tests\LaravelTestCase;
use Arcanedev\Units\UnitsServiceProvider;

/**
 * Class     UnitsServiceProviderTest
 *
 * @package  Arcanedev\Units\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsServiceProviderTest extends LaravelTestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  \Arcanedev\Units\UnitsServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(UnitsServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanedev\Units\UnitsServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            \Arcanedev\Units\Contracts\UnitsManager::class,
        ];

        $this->assertSame($expected, $this->provider->provides());
    }
}
