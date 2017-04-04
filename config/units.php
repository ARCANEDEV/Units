<?php

use Arcanedev\Units\Contracts\Measures\Distance;
use Arcanedev\Units\Contracts\Measures\FileSize;
use Arcanedev\Units\Contracts\Measures\LiquidVolume;
use Arcanedev\Units\Contracts\Measures\Weight;

return [
    /* -----------------------------------------------------------------
     |  Distance Unit
     | -----------------------------------------------------------------
     */
    'distance'      => [
        'default' => Distance::M,
        'symbols' => [
            Distance::KM  => 'km',
            Distance::HM  => 'hm',
            Distance::DAM => 'dam',
            Distance::M   => 'm',
            Distance::DM  => 'dm',
            Distance::CM  => 'cm',
            Distance::MM  => 'mm',
        ],
        'names'   => [
            Distance::KM  => 'Kilometer',
            Distance::HM  => 'Hectometer',
            Distance::DAM => 'Decameter',
            Distance::M   => 'Meter',
            Distance::DM  => 'Decimeter',
            Distance::CM  => 'Centimeter',
            Distance::MM  => 'Millimeter',
        ],
        'format'  => [
            'decimals'            => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => ' ',
        ],
    ],

    /* -----------------------------------------------------------------
     |  File Size Unit
     | -----------------------------------------------------------------
     */
    'file-size'     => [
        'default' => FileSize::B,

        'symbols' => [
            FileSize::YB => 'yb',
            FileSize::ZB => 'zb',
            FileSize::EB => 'eb',
            FileSize::PB => 'pb',
            FileSize::TB => 'tb',
            FileSize::GB => 'gb',
            FileSize::MB => 'mb',
            FileSize::KB => 'kb',
            FileSize::B  => 'b',
        ],

        'names'   => [
            FileSize::YB => 'yottabyte',
            FileSize::ZB => 'zettabyte',
            FileSize::EB => 'exabyte',
            FileSize::PB => 'petabyte',
            FileSize::TB => 'terabyte',
            FileSize::GB => 'gigabyte',
            FileSize::MB => 'megabyte',
            FileSize::KB => 'kilobyte',
            FileSize::B  => 'b',
        ],

        'format'  => [
            'decimals'            => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => ' ',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Liquid Volume Unit
     | -----------------------------------------------------------------
     */
    'liquid-volume' => [
        'default' => LiquidVolume::L,

        'symbols' => [
            LiquidVolume::KL  => 'kl',
            LiquidVolume::HL  => 'hl',
            LiquidVolume::DAL => 'dal',
            LiquidVolume::L   => 'l',
            LiquidVolume::DL  => 'dl',
            LiquidVolume::CL  => 'cl',
            LiquidVolume::ML  => 'ml',
        ],

        'names'   => [
            LiquidVolume::KL  => 'Kilolitre',
            LiquidVolume::HL  => 'Hectolitre',
            LiquidVolume::DAL => 'Decalitre',
            LiquidVolume::L   => 'Litre',
            LiquidVolume::DL  => 'Decilitre',
            LiquidVolume::CL  => 'Centilitre',
            LiquidVolume::ML  => 'Millilitre',
        ],

        'format'  => [
            'decimals'            => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => ' ',
        ],
    ],

    /* -----------------------------------------------------------------
     |  Weight Unit
     | -----------------------------------------------------------------
     */
    'weight'        => [
        'default' => Weight::KG,
        'symbols' => [
            Weight::TON => 't',
            Weight::KG  => 'kg',
            Weight::G   => 'g',
            Weight::MG  => 'mg',
        ],
        'names'   => [
            Weight::TON => 'Ton',
            Weight::KG  => 'Kilogram',
            Weight::G   => 'Gram',
            Weight::MG  => 'Milligram',
        ],
        'format'  => [
            'decimals'            => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => ' ',
        ],
    ],
];
