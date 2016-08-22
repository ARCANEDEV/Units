<?php namespace Arcanedev\Units\Contracts\Traits;
use Arcanedev\Units\Contracts\UnitMeasure;

/**
 * Interface  Calculatable
 *
 * @package   Arcanedev\Units\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Calculatable
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Add the unit instance.
     *
     * @param  \Arcanedev\Units\Contracts\UnitMeasure  $unit
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function add(UnitMeasure $unit);

    /**
     * Sub the unit instance.
     *
     * @param  \Arcanedev\Units\Contracts\UnitMeasure  $unit
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function sub(UnitMeasure $unit);

    /**
     * Multiply unit by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function multiply($number);

    /**
     * Divide unit by the given number.
     *
     * @param  float|int  $number
     *
     * @return \Arcanedev\Units\Contracts\UnitMeasure
     */
    public function divide($number);
}
