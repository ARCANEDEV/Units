<?php namespace Arcanedev\Units\Tests\Laravel;

use Arcanedev\Units\Tests\LaravelTestCase;

/**
 * Class     UnitsManagerTest
 *
 * @package  Arcanedev\Units\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsManagerTest extends LaravelTestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Units\UnitsManager */
    protected $manager;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->manager = $this->app->make(\Arcanedev\Units\Contracts\UnitsManager::class);
    }

    public function tearDown()
    {
        unset($this->manager);

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
            \Illuminate\Support\Manager::class,
            \Arcanedev\Units\Contracts\UnitsManager::class,
            \Arcanedev\Units\UnitsManager::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->manager);
        }
    }

    /**
     * @test
     *
     * @expectedException         \InvalidArgumentException
     * @expectedExceptionMessage  No unit of measurement was specified.
     */
    public function it_must_throw_an_exception_if_driver_was_not_specified()
    {
        $this->manager->driver();
    }

    /** @test */
    public function it_can_instantiate_distance_unit()
    {
        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Distance::class,
            $this->manager->driver('distance')
        );

        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Distance::class,
            $this->manager->distance()
        );
    }

    /** @test */
    public function it_can_instantiate_file_size_unit()
    {
        static::assertInstanceOf(
            \Arcanedev\Units\Measures\FileSize::class,
            $this->manager->driver('file-size')
        );

        static::assertInstanceOf(
            \Arcanedev\Units\Measures\FileSize::class,
            $this->manager->fileSize()
        );
    }

    /** @test */
    public function it_can_instantiate_weight_unit()
    {
        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Weight::class,
            $this->manager->driver('weight')
        );

        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Weight::class,
            $this->manager->weight()
        );
    }

    /** @test */
    public function it_can_instantiate_liquid_volume_unit()
    {
        static::assertInstanceOf(
            \Arcanedev\Units\Measures\LiquidVolume::class,
            $this->manager->driver('liquid-volume')
        );

        static::assertInstanceOf(
            \Arcanedev\Units\Measures\LiquidVolume::class,
            $this->manager->liquidVolume()
        );
    }

    /** @test */
    public function it_can_be_instantiated_by_facade()
    {
        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Distance::class,
            \Arcanedev\Units\Facades\Unit::driver('distance')
        );

        static::assertInstanceOf(
            \Arcanedev\Units\Measures\Distance::class,
            \Arcanedev\Units\Facades\Unit::distance()
        );
    }
}
