<?php namespace Arcanedev\Units\Tests\Measures;

use Arcanedev\Units\Measures\Weight;
use Arcanedev\Units\Tests\TestCase;

class WeightTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  \Arcanedev\Units\Contracts\Weight */
    private $weight;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->weight = new Weight;
    }

    public function tearDown()
    {
        unset($this->weight);

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
            \Arcanedev\Units\Contracts\Weight::class,
            \Arcanedev\Units\Measures\Weight::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->weight);
        }

        $this->assertSame(0, $this->weight->value());
        $this->assertSame(Weight::KG, $this->weight->unit());
        $this->assertSame('kg', $this->weight->symbol());
    }

    /** @test */
    public function it_can_make()
    {
        $this->weight = Weight::make();
        $expectations = [
            \Arcanedev\Units\Contracts\Weight::class,
            \Arcanedev\Units\Measures\Weight::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->weight);
        }

        $this->assertSame(0, $this->weight->value());
        $this->assertSame(Weight::KG, $this->weight->unit());
    }

    /** @test */
    public function it_can_get_available_units()
    {
        $units = Weight::units();

        $this->assertCount(4, $units);
        $this->assertSame([
            Weight::TON,
            Weight::KG,
            Weight::G,
            Weight::MG,
        ], $units);
    }

    /** @test */
    public function it_can_get_unit_names()
    {
        $names = Weight::names();

        $this->assertCount(4, $names);

        foreach (Weight::units() as $unit) {
            $this->assertArrayHasKey($unit, $names);

            $name = $names[$unit];

            $this->assertNotSame($unit, $name);
            $this->assertSame(Weight::getSymbolName($unit), $name);
        }
    }

    /** @test */
    public function it_can_get_default_symbols()
    {
        $units = Weight::units();

        foreach ($this->weight->symbols() as $unit => $symbol) {
            $this->assertTrue(in_array($unit, $units));
            $this->assertSame($unit, $symbol);
        }
    }

    /** @test */
    public function it_can_convert_to_another_unit()
    {
        $values = [1, 2, 3.4, 56.7, 0.98];

        foreach ($values as $value) {
            $converted = Weight::make($value, Weight::KG)->to(Weight::G);

            $this->assertSame(Weight::G,     $converted->unit());
            $this->assertSame($value * 1000, $converted->value());
        }
    }

    /** @test */
    public function it_can_skip_convert_if_same_unit()
    {
        $converted = $this->weight->setValue(1)->to($this->weight->unit());

        $this->assertSame($this->weight->unit(),  $converted->unit());
        $this->assertSame($this->weight->value(), $converted->value());
    }
}
