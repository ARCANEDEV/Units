<?php namespace Arcanedev\Units\Tests\Measures;

use Arcanedev\Units\Measures\Weight;
use Arcanedev\Units\Tests\TestCase;

/**
 * Class     WeightTest
 *
 * @package  Arcanedev\Units\Tests\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class WeightTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Units\Contracts\Measures\Weight */
    private $weight;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Arcanedev\Units\Bases\UnitMeasure::class,
            \Arcanedev\Units\Contracts\Measures\Weight::class,
            \Arcanedev\Units\Measures\Weight::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->weight);
        }

        static::assertSame(0, $this->weight->value());
        static::assertSame(Weight::KG, $this->weight->unit());
        static::assertSame('kg', $this->weight->symbol());
        static::assertSame('kilogram', $this->weight->name());
    }

    /** @test */
    public function it_can_make()
    {
        $this->weight = Weight::make();
        $expectations = [
            \Arcanedev\Units\Contracts\Measures\Weight::class,
            \Arcanedev\Units\Measures\Weight::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->weight);
        }

        static::assertSame(0, $this->weight->value());
        static::assertSame(Weight::KG, $this->weight->unit());
    }

    /** @test */
    public function it_can_get_available_units()
    {
        $units = Weight::units();

        static::assertCount(4, $units);
        static::assertSame([
            Weight::TON,
            Weight::KG,
            Weight::G,
            Weight::MG,
        ], $units);
    }

    /** @test */
    public function it_can_get_unit_names()
    {
        $names = $this->weight->names();

        static::assertCount(4, $names);

        foreach (Weight::units() as $unit) {
            static::assertArrayHasKey($unit, $names);

            $name = $names[$unit];

            static::assertNotSame($unit, $name);
            static::assertSame($this->weight->getName($unit), $name);
        }
    }

    /** @test */
    public function it_can_get_default_symbols()
    {
        $units = Weight::units();

        foreach ($this->weight->symbols() as $unit => $symbol) {
            static::assertTrue(in_array($unit, $units));
            static::assertSame($unit, $symbol);
        }
    }

    /** @test */
    public function it_can_convert_to_another_unit()
    {
        $values = [1, 2, 3.4, 56.7, 0.98];

        foreach ($values as $value) {
            $converted = Weight::make($value, Weight::KG)->to(Weight::G);

            static::assertSame(Weight::G,     $converted->unit());
            static::assertSame($value * 1000, $converted->value());
        }
    }

    /** @test */
    public function it_can_skip_convert_if_same_unit()
    {
        $converted = $this->weight->setValue(1)->to($this->weight->unit());

        static::assertSame($this->weight->unit(),  $converted->unit());
        static::assertSame($this->weight->value(), $converted->value());
    }

    /** @test */
    public function it_can_format()
    {
        static::assertSame('0', $this->weight->format());

        $this->weight->setValue(1234.567);

        static::assertSame('1.235', $this->weight->format());
        static::assertSame('1.234,567', $this->weight->format(3));
    }

    /** @test */
    public function it_can_format_with_symbol()
    {
        static::assertSame('0 kg', $this->weight->formatWithSymbol());

        $this->weight->setValue(1234.567);

        static::assertSame('1.235 kg',     $this->weight->formatWithSymbol());
        static::assertSame('1.234,567 kg', $this->weight->formatWithSymbol(3));
    }

    /** @test */
    public function it_can_format_with_symbol_when_it_casts_to_string()
    {
        static::assertSame('0 kg', (string) $this->weight);

        $this->weight->setValue(1234.567);

        static::assertSame('1.235 kg', (string) $this->weight);

        $this->weight->setValue(-1234.567);

        static::assertSame('-1.235 kg', (string) $this->weight);
    }

    /* -----------------------------------------------------------------
     |  Calculation Tests
     | -----------------------------------------------------------------
     */
    /** @test */
    public function it_can_add()
    {
        $total  = 0;
        $values = [1, 10, 100, 1000, 0.1, 0.01];

        foreach ($values as $value) {
            $this->weight->addWeight($value);
            $total += $value;

            static::assertSame($total, $this->weight->value());
        }
    }

    /** @test */
    public function it_can_add_negative_value()
    {
        $this->weight->addWeight(-1);

        static::assertSame(-1, $this->weight->value());
    }

    /** @test */
    public function it_can_add_another_weight_object()
    {
        $total  = 0;
        $values = [1, 10, 100, 1000, 0.1, 0.01];

        foreach ($values as $value) {
            $w = Weight::make($value);

            $this->weight->add($w);

            $total += $w->value();

            static::assertSame($total, $this->weight->value());
        }
    }

    /** @test */
    public function it_can_add_another_weight_object_with_different_unit()
    {
        $w = Weight::make(1, Weight::TON);

        $this->weight->add($w);

        static::assertSame(1000, $this->weight->value());
    }

    /** @test */
    public function it_can_subtract()
    {
        $this->weight->subWeight(1);

        static::assertSame(-1, $this->weight->value());

        $this->weight->subWeight(99);

        static::assertSame(-100, $this->weight->value());
    }

    /** @test */
    public function it_can_subtract_with_negative_value()
    {
        $this->weight->subWeight(-1);

        static::assertSame(1, $this->weight->value());

        $this->weight->subWeight(-99);

        static::assertSame(100, $this->weight->value());
    }

    /** @test */
    public function it_can_multiply()
    {
        $this->weight->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->weight->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->weight->value());
        }
    }

    /** @test */
    public function it_can_multiply_with_negative_value()
    {
        $this->weight->setValue(1);

        $total  = 1;
        $values = range(-10, -1);

        foreach ($values as $value) {
            $this->weight->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->weight->value());
        }
    }

    /** @test */
    public function it_can_divide()
    {
        $this->weight->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->weight->divide($value);
            $total /= $value;
            static::assertSame($total, $this->weight->value());
        }
    }

    /**
     * @test
     *
     * @expectedException         \InvalidArgumentException
     * @expectedExceptionMessage  Invalid unit of measurement [litre] in Arcanedev\Units\Measures\Weight.
     */
    public function it_must_throw_an_exception_on_invalid_unit()
    {
        $this->weight->setUnit('litre');
    }

    /** @test */
    public function it_must_throw_divide_by_zero_exception()
    {
        try {
            $this->weight->divide(0);
        }
        catch (\Exception $e) {
            static::assertEquals('Division by zero', $e->getMessage());
        }
    }
}
