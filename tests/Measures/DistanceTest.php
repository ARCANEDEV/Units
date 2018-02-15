<?php namespace Arcanedev\Units\Tests\Measures;

use Arcanedev\Units\Measures\Distance;
use Arcanedev\Units\Tests\TestCase;

/**
 * Class     DistanceTest
 *
 * @package  Arcanedev\Units\Tests\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DistanceTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Units\Contracts\Measures\Distance */
    private $distance;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->distance = new Distance;
    }

    public function tearDown()
    {
        unset($this->distance);

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
            \Arcanedev\Units\Contracts\Measures\Distance::class,
            \Arcanedev\Units\Measures\Distance::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->distance);
        }

        static::assertSame(0, $this->distance->value());
        static::assertSame(Distance::M, $this->distance->unit());
        static::assertSame('m', $this->distance->symbol());
        static::assertSame('metre', $this->distance->name());
    }

    /** @test */
    public function it_can_make()
    {
        $this->distance = Distance::make();
        $expectations   = [
            \Arcanedev\Units\Bases\UnitMeasure::class,
            \Arcanedev\Units\Contracts\Measures\Distance::class,
            \Arcanedev\Units\Measures\Distance::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->distance);
        }

        static::assertSame(0, $this->distance->value());
        static::assertSame(Distance::M, $this->distance->unit());
    }

    /** @test */
    public function it_can_get_available_units()
    {
        $units = Distance::units();

        static::assertCount(7, $units);
        static::assertSame([
            Distance::KM,
            Distance::HM,
            Distance::DAM,
            Distance::M,
            Distance::DM,
            Distance::CM,
            Distance::MM,
        ], $units);
    }

    /** @test */
    public function it_can_get_unit_names()
    {
        $names = $this->distance->names();

        static::assertCount(7, $names);

        foreach (Distance::units() as $unit) {
            static::assertArrayHasKey($unit, $names);

            $name = $names[$unit];

            static::assertNotSame($unit, $name);
            static::assertSame($this->distance->getName($unit), $name);
        }
    }

    /** @test */
    public function it_can_get_default_symbols()
    {
        $units = Distance::units();

        foreach ($this->distance->symbols() as $unit => $symbol) {
            static::assertTrue(in_array($unit, $units));
            static::assertSame($unit, $symbol);
        }
    }

    /** @test */
    public function it_can_convert_to_another_unit()
    {
        $values = [1, 2, 3.4, 56.7, 0.98];

        foreach ($values as $value) {
            $converted = Distance::make($value, Distance::KM)->to(Distance::M);

            static::assertSame(Distance::M,   $converted->unit());
            static::assertSame($value * 1000, $converted->value());
        }
    }

    /** @test */
    public function it_can_skip_convert_if_same_unit()
    {
        $converted = $this->distance->setValue(1)->to($this->distance->unit());

        static::assertSame($this->distance->unit(),  $converted->unit());
        static::assertSame($this->distance->value(), $converted->value());
    }

    /** @test */
    public function it_can_format()
    {
        static::assertSame('0', $this->distance->format());

        $this->distance->setValue(1234.567);

        static::assertSame('1.235', $this->distance->format());
        static::assertSame('1.234,567', $this->distance->format(3));
    }

    /** @test */
    public function it_can_format_with_symbol()
    {
        static::assertSame('0 m', $this->distance->formatWithSymbol());

        $this->distance->setValue(1234.567);

        static::assertSame('1.235 m',     $this->distance->formatWithSymbol());
        static::assertSame('1.234,567 m', $this->distance->formatWithSymbol(3));

        $this->distance = $this->distance->to(Distance::KM);

        static::assertSame('1 km',     $this->distance->formatWithSymbol());
        static::assertSame('1,235 km', $this->distance->formatWithSymbol(3));

        $this->distance = $this->distance->to(Distance::MM);

        static::assertSame('1.234.567 mm', $this->distance->formatWithSymbol());
    }

    /** @test */
    public function it_can_format_with_symbol_when_it_casts_to_string()
    {
        static::assertSame('0 m', (string) $this->distance);

        $this->distance->setValue(1234.567);

        static::assertSame('1.235 m', (string) $this->distance);

        $this->distance = $this->distance->setValue(-1234.567);

        static::assertSame('-1.235 m', (string) $this->distance);
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
            $this->distance->addDistance($value);
            $total += $value;

            static::assertSame($total, $this->distance->value());
        }
    }

    /** @test */
    public function it_can_add_negative_value()
    {
        $this->distance->addDistance(-1);

        static::assertSame(-1, $this->distance->value());
    }

    /** @test */
    public function it_can_add_another_distance_object()
    {
        $total  = 0;
        $values = [1, 10, 100, 1000, 0.1, 0.01];

        foreach ($values as $value) {
            $w = Distance::make($value);

            $this->distance->add($w);

            $total += $w->value();

            static::assertSame($total, $this->distance->value());
        }
    }

    /** @test */
    public function it_can_add_another_distance_object_with_different_unit()
    {
        $dist = Distance::make(1, Distance::KM);

        $this->distance->add($dist);

        static::assertSame(1000, $this->distance->value());
    }

    /** @test */
    public function it_can_subtract()
    {
        $this->distance->subDistance(1);

        static::assertSame(-1, $this->distance->value());

        $this->distance->subDistance(99);

        static::assertSame(-100, $this->distance->value());
    }

    /** @test */
    public function it_can_subtract_with_negative_value()
    {
        $this->distance->subDistance(-1);

        static::assertSame(1, $this->distance->value());

        $this->distance->subDistance(-99);

        static::assertSame(100, $this->distance->value());
    }

    /** @test */
    public function it_can_multiply()
    {
        $this->distance->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->distance->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->distance->value());
        }
    }

    /** @test */
    public function it_can_multiply_with_negative_value()
    {
        $this->distance->setValue(1);

        $total  = 1;
        $values = range(-10, -1);

        foreach ($values as $value) {
            $this->distance->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->distance->value());
        }
    }

    /** @test */
    public function it_can_divide()
    {
        $this->distance->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->distance->divide($value);
            $total /= $value;
            static::assertSame($total, $this->distance->value());
        }
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Units\Exceptions\InvalidUnitException
     * @expectedExceptionMessage  Invalid unit of measurement [litre] in Arcanedev\Units\Measures\Distance.
     */
    public function it_must_throw_an_exception_on_invalid_unit()
    {
        $this->distance->setUnit('litre');
    }

    /** @test */
    public function it_must_throw_divide_by_zero_exception()
    {
        try {
            $this->distance->divide(0);
        }
        catch (\Exception $e) {
            static::assertEquals('Division by zero', $e->getMessage());
        }
    }
}
