<?php namespace Arcanedev\Units\Tests\Traits;

use Arcanedev\Units\Tests\Stubs\Calculator;
use Arcanedev\Units\Tests\TestCase;

/**
 * Class     CalculatableTest
 *
 * @package  Arcanedev\Units\Tests\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CalculatableTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_add()
    {
        $this->assertSame(3, Calculator::add(1, 2));
    }

    /** @test */
    public function it_can_subtract()
    {
        $this->assertSame(1, Calculator::sub(3, 2));
    }

    /** @test */
    public function it_can_multiply()
    {
        $this->assertSame(6, Calculator::multiply(3, 2));
    }

    /** @test */
    public function it_can_divide()
    {
        $this->assertSame(4, Calculator::divide(8, 2));
    }

    /** @test */
    public function it_can_pow()
    {
        $this->assertSame(100, Calculator::pow(10, 2));
    }

    /** @test */
    public function it_can_skip_calculation_on_wrong_operator()
    {
        $this->assertSame(5, Calculator::dummy(5, 100000));
    }
}
