<?php namespace Arcanedev\Units\Tests\Measures;

use Arcanedev\Units\Measures\FileSize;
use Arcanedev\Units\Tests\LaravelTestCase;

/**
 * Class     FileSizeTest
 *
 * @package  Arcanedev\Units\Tests\Measures
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class FileSizeTest extends LaravelTestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\Units\Measures\FileSize */
    protected $fileSize;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function setUp()
    {
        parent::setUp();

        $this->fileSize = new FileSize;
    }

    public function tearDown()
    {
        unset($this->fileSize);

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
            \Arcanedev\Units\Contracts\Measures\FileSize::class,
            \Arcanedev\Units\Measures\FileSize::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->fileSize);
        }

        static::assertSame(0, $this->fileSize->value());
        static::assertSame(FileSize::B, $this->fileSize->unit());
        static::assertSame('B', $this->fileSize->symbol());
        static::assertSame('byte', $this->fileSize->name());
    }

    /** @test */
    public function it_can_make()
    {
        $this->fileSize = FileSize::make();
        $expectations   = [
            \Arcanedev\Units\Bases\UnitMeasure::class,
            \Arcanedev\Units\Contracts\Measures\FileSize::class,
            \Arcanedev\Units\Measures\FileSize::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->fileSize);
        }

        static::assertSame(0, $this->fileSize->value());
        static::assertSame(FileSize::B, $this->fileSize->unit());
    }

    /** @test */
    public function it_can_get_available_units()
    {
        $units = FileSize::units();

        static::assertCount(9, $units);
        static::assertSame([
            FileSize::YB,
            FileSize::ZB,
            FileSize::EB,
            FileSize::PB,
            FileSize::TB,
            FileSize::GB,
            FileSize::MB,
            FileSize::KB,
            FileSize::B,
        ], $units);
    }

    /** @test */
    public function it_can_get_unit_names()
    {
        $names = $this->fileSize->names();

        static::assertCount(9, $names);

        foreach (FileSize::units() as $unit) {
            static::assertArrayHasKey($unit, $names);

            $name = $names[$unit];

            static::assertNotSame($unit, $name);
            static::assertSame($this->fileSize->getName($unit), $name);
        }
    }

    /** @test */
    public function it_can_get_default_symbols()
    {
        $units = FileSize::units();

        foreach ($this->fileSize->symbols() as $unit => $symbol) {
            static::assertTrue(in_array($unit, $units));
            static::assertSame($unit, $symbol);
        }
    }

    /** @test */
    public function it_can_convert_to_another_unit()
    {
        $values = [1, 2, 3.4, 56.7, 0.98];

        foreach ($values as $value) {
            $converted = FileSize::make($value, FileSize::KB)->to(FileSize::B);

            static::assertSame(FileSize::B,   $converted->unit());
            static::assertEquals($value * 1024, $converted->value());
        }
    }

    /** @test */
    public function it_can_skip_convert_if_same_unit()
    {
        $converted = $this->fileSize->setValue(1)->to($this->fileSize->unit());

        static::assertSame($this->fileSize->unit(),  $converted->unit());
        static::assertSame($this->fileSize->value(), $converted->value());
    }

    /** @test */
    public function it_can_format()
    {
        static::assertSame('0', $this->fileSize->format());

        $this->fileSize->setValue(1234.567);

        static::assertSame('1.235', $this->fileSize->format());
        static::assertSame('1.234,567', $this->fileSize->format(3));
    }

    /** @test */
    public function it_can_format_with_symbol()
    {
        static::assertSame('0 B', $this->fileSize->formatWithSymbol());

        $this->fileSize->setValue(1234.567);

        static::assertSame('1.235 B',     $this->fileSize->formatWithSymbol());
        static::assertSame('1.234,567 B', $this->fileSize->formatWithSymbol(3));

        $this->fileSize = $this->fileSize->to(FileSize::KB);

        static::assertSame('1 kB',     $this->fileSize->formatWithSymbol());
        static::assertSame('1,206 kB', $this->fileSize->formatWithSymbol(3));

        $this->fileSize = $this->fileSize->to(FileSize::B);

        static::assertSame('1.235 B', $this->fileSize->formatWithSymbol());
    }

    /** @test */
    public function it_can_format_with_symbol_when_it_casts_to_string()
    {
        static::assertSame('0 B', (string) $this->fileSize);

        $this->fileSize->setValue(1234.567);

        static::assertSame('1.235 B', (string) $this->fileSize);

        $this->fileSize = $this->fileSize->setValue(-1234.567);

        static::assertSame('-1.235 B', (string) $this->fileSize);
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
            $this->fileSize->addSize($value);
            $total += $value;

            static::assertSame($total, $this->fileSize->value());
        }
    }

    /** @test */
    public function it_can_add_negative_value()
    {
        $this->fileSize->addSize(-1);

        static::assertSame(-1, $this->fileSize->value());
    }

    /** @test */
    public function it_can_add_another_file_size_object()
    {
        $total  = 0;
        $values = [1, 10, 100, 1000, 0.1, 0.01];

        foreach ($values as $value) {
            $s = FileSize::make($value);

            $this->fileSize->add($s);

            $total += $s->value();

            static::assertSame($total, $this->fileSize->value());
        }
    }

    /** @test */
    public function it_can_add_another_file_size_object_with_different_unit()
    {
        $size = FileSize::make(1, FileSize::KB);

        $this->fileSize->add($size);

        static::assertSame(1024.0, $this->fileSize->value());
    }

    /** @test */
    public function it_can_subtract()
    {
        $this->fileSize->subSize(1);

        static::assertSame(-1, $this->fileSize->value());

        $this->fileSize->subSize(99);

        static::assertSame(-100, $this->fileSize->value());
    }

    /** @test */
    public function it_can_subtract_with_negative_value()
    {
        $this->fileSize->subSize(-1);

        static::assertSame(1, $this->fileSize->value());

        $this->fileSize->subSize(-99);

        static::assertSame(100, $this->fileSize->value());
    }

    /** @test */
    public function it_can_multiply()
    {
        $this->fileSize->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->fileSize->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->fileSize->value());
        }
    }

    /** @test */
    public function it_can_multiply_with_negative_value()
    {
        $this->fileSize->setValue(1);

        $total  = 1;
        $values = range(-10, -1);

        foreach ($values as $value) {
            $this->fileSize->multiply($value);
            $total *= $value;
            static::assertSame($total, $this->fileSize->value());
        }
    }

    /** @test */
    public function it_can_divide()
    {
        $this->fileSize->setValue(1);

        $total  = 1;
        $values = range(1, 10);

        foreach ($values as $value) {
            $this->fileSize->divide($value);
            $total /= $value;
            static::assertSame($total, $this->fileSize->value());
        }
    }

    /**
     * @test
     *
     * @expectedException         \Arcanedev\Units\Exceptions\InvalidUnitException
     * @expectedExceptionMessage  Invalid unit of measurement [litre] in Arcanedev\Units\Measures\FileSize.
     */
    public function it_must_throw_an_exception_on_invalid_unit()
    {
        $this->fileSize->setUnit('litre');
    }

    /** @test */
    public function it_must_throw_divide_by_zero_exception()
    {
        try {
            $this->fileSize->divide(0);
        }
        catch (\Exception $e) {
            static::assertEquals('Division by zero', $e->getMessage());
        }
    }
}
