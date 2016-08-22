<?php namespace Arcanedev\Units\Tests;

/**
 * Class     UnitsManagerTest
 *
 * @package  Arcanedev\Units\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UnitsManagerTest extends LaravelTestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  \Arcanedev\Units\UnitsManager */
    private $manager;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->manager = $this->app->make('arcanedev.units.manager');
    }

    public function tearDown()
    {
        unset($this->manager);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
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
            $this->assertInstanceOf($expected, $this->manager);
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
        $distance = $this->manager->driver('distance');

        $this->assertInstanceOf(\Arcanedev\Units\Measures\Distance::class, $distance);
    }

    /** @test */
    public function it_can_instantiate_weight_unit()
    {
        $weight = $this->manager->driver('weight');

        $this->assertInstanceOf(\Arcanedev\Units\Measures\Weight::class, $weight);
    }

    /** @test */
    public function it_can_instantiate_liquid_volume_unit()
    {
        $volume = $this->manager->driver('liquid-volume');

        $this->assertInstanceOf(\Arcanedev\Units\Measures\LiquidVolume::class, $volume);
    }
}
