<?php namespace Arcanedev\Units\Contracts\Measures;

/**
 * Interface  FileSize
 *
 * @package   Arcanedev\Units\Contracts\Measures
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface FileSize
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */
    const YB = 'YB';
    const ZB = 'ZB';
    const EB = 'EB';
    const PB = 'PB';
    const TB = 'TB';
    const GB = 'GB';
    const MB = 'MB';
    const KB = 'kB';
    const B  = 'B';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Make a file size instance.
     *
     * @param  float|int  $value
     * @param  string     $unit
     * @param  array      $options
     *
     * @return static
     */
    public static function make($value = 0, $unit = self::B, array $options = []);
}
