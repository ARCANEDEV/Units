<?php namespace Arcanedev\Units\Tests\Measures;

use Arcanedev\Units\Measures\LiquidVolume;
use Arcanedev\Units\Tests\TestCase;

/**
 * Class     LiquidVolumeTest
 *
 * @package  Arcanedev\Units\Tests\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LiquidVolumeTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var  \Arcanedev\Units\Contracts\Measures\LiquidVolume */
    private $volume;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->volume = new LiquidVolume;
    }

    public function tearDown()
    {
        unset($this->volume);

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
            \Arcanedev\Units\Contracts\Measures\LiquidVolume::class,
            \Arcanedev\Units\Measures\LiquidVolume::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->volume);
        }

        $this->assertSame(0, $this->volume->value());
        $this->assertSame(LiquidVolume::L, $this->volume->unit());
        $this->assertSame('l', $this->volume->symbol());
        $this->assertSame('litre', $this->volume->name());
    }

    /** @test */
    public function it_can_make()
    {
        $this->volume = LiquidVolume::make();
        $expectations   = [
            \Arcanedev\Units\Bases\UnitMeasure::class,
            \Arcanedev\Units\Contracts\Measures\LiquidVolume::class,
            \Arcanedev\Units\Measures\LiquidVolume::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->volume);
        }

        $this->assertSame(0, $this->volume->value());
        $this->assertSame(LiquidVolume::L, $this->volume->unit());
    }

    /** @test */
    public function it_can_get_available_units()
    {
        $units = LiquidVolume::units();

        $this->assertCount(7, $units);
        $this->assertSame([
            LiquidVolume::KL,
            LiquidVolume::HL,
            LiquidVolume::DAL,
            LiquidVolume::L,
            LiquidVolume::DL,
            LiquidVolume::CL,
            LiquidVolume::ML,
        ], $units);
    }

    /** @test */
    public function it_can_get_unit_names()
    {
        $names = $this->volume->names();

        $this->assertCount(7, $names);

        foreach (LiquidVolume::units() as $unit) {
            $this->assertArrayHasKey($unit, $names);

            $name = $names[$unit];

            $this->assertNotSame($unit, $name);
            $this->assertSame($this->volume->getName($unit), $name);
        }
    }

    /** @test */
    public function it_can_get_default_symbols()
    {
        $units = LiquidVolume::units();

        foreach ($this->volume->symbols() as $unit => $symbol) {
            $this->assertTrue(in_array($unit, $units));
            $this->assertSame($unit, $symbol);
        }
    }

    /** @test */
    public function it_can_convert_to_another_unit()
    {
        $values = [1, 2, 3.4, 56.7, 0.98];

        foreach ($values as $value) {
            $converted = LiquidVolume::make($value, LiquidVolume::KL)->to(LiquidVolume::L);

            $this->assertSame(LiquidVolume::L,   $converted->unit());
            $this->assertSame($value * 1000, $converted->value());
        }
    }

    /** @test */
    public function it_can_skip_convert_if_same_unit()
    {
        $converted = $this->volume->setValue(1)->to($this->volume->unit());

        $this->assertSame($this->volume->unit(),  $converted->unit());
        $this->assertSame($this->volume->value(), $converted->value());
    }

    /** @test */
    public function it_can_format()
    {
        $this->assertSame('0', $this->volume->format());

        $this->volume->setValue(1234.567);

        $this->assertSame('1.235', $this->volume->format());
        $this->assertSame('1.234,567', $this->volume->format(3));
    }

    /** @test */
    public function it_can_format_with_symbol()
    {
        $this->assertSame('0 l', $this->volume->formatWithSymbol());

        $this->volume->setValue(1234.567);

        $this->assertSame('1.235 l',     $this->volume->formatWithSymbol());
        $this->assertSame('1.234,567 l', $this->volume->formatWithSymbol(3));

        $this->volume = $this->volume->to(LiquidVolume::KL);

        $this->assertSame('1 kl',     $this->volume->formatWithSymbol());
        $this->assertSame('1,235 kl', $this->volume->formatWithSymbol(3));

        $this->volume = $this->volume->to(LiquidVolume::ML);

        $this->assertSame('1.234.567 ml', $this->volume->formatWithSymbol());
    }

    /** @test */
    public function it_can_format_with_symbol_when_it_casts_to_string()
    {
        $this->assertSame('0 l', (string) $this->volume);

        $this->volume->setValue(1234.567);

        $this->assertSame('1.235 l', (string) $this->volume);

        $this->volume = $this->volume->setValue(-1234.567);

        $this->assertSame('-1.235 l', (string) $this->volume);
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
            $this->volume->addVolume($value);
            $total += $value;

            $this->assertSame($total, $this->volume->value());
        }
    }

    /** @test */
    public function it_can_add_negative_value()
    {
        $this->volume->addVolume(-1);

        $this->assertSame(-1, $this->volume->value());
    }

    /** @test */
    public function it_can_add_another_volume_object()
    {
        $total  = 0;
        $values = [1, 10, 100, 1000, 0.1, 0.01];

        foreach ($values as $value) {
            $w = LiquidVolume::make($value);

            $this->volume->add($w);

            $total += $w->value();

            $this->assertSame($total, $this->volume->value());
        }
    }

    /** @test */
    public function it_can_add_another_volume_object_with_different_unit()
    {
        $dist = LiquidVolume::make(1, LiquidVolume::KL);

        $this->volume->add($dist);

        $this->assertSame(1000, $this->volume->value());
    }

    /** @test */
    public function it_can_subtract()
    {
        $this->volume->subVolume(1);

        $this->assertSame(-1, $this->volume->value());

        $this->volume->subVolume(99);

        $this->assertSame(-100, $this->volume->value());
    }

    /** @test */
    public function it_can_subtract_with_negative_value()
    {
        $this->volume->subVolume(-1);

        $this->assertSame(1, $this->volume->value());

        $this->volume->subVolume(-99);

        $this->assertSame(100, $this->volume->value());
    }

    /** @test */
    public function it_can_multiply()
    {
        $this->volume->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->volume->multiply($value);
            $total *= $value;
            $this->assertSame($total, $this->volume->value());
        }
    }

    /** @test */
    public function it_can_multiply_with_negative_value()
    {
        $this->volume->setValue(1);

        $total  = 1;
        $values = range(-10, -1);

        foreach ($values as $value) {
            $this->volume->multiply($value);
            $total *= $value;
            $this->assertSame($total, $this->volume->value());
        }
    }

    /** @test */
    public function it_can_divide()
    {
        $this->volume->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->volume->divide($value);
            $total /= $value;
            $this->assertSame($total, $this->volume->value());
        }
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Units\Exceptions\InvalidUnitException
     * @expectedExceptionMessage  Invalid unit of measurement [meter] in Arcanedev\Units\Measures\LiquidVolume.
     */
    public function it_must_throw_an_exception_on_invalid_unit()
    {
        $this->volume->setUnit('meter');
    }

    /** @test */
    public function it_must_throw_divide_by_zero_exception()
    {
        try {
            $this->volume->divide(0);
        }
        catch (\Exception $e) {
            $this->assertEquals('Division by zero', $e->getMessage());
        }
    }
}
