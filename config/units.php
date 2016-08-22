<?php

use Arcanedev\Units\Contracts\Measures\Distance;
use Arcanedev\Units\Contracts\Measures\LiquidVolume;
use Arcanedev\Units\Contracts\Measures\Weight;

return [
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
        'options'  => [
            'decimals' => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => '.',
        ],
    ],
    'liquid-volume' => [
        'default' => LiquidVolume::L,
        'symbols' => [
            LiquidVolume::KL  => 'Ll',
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
            'decimals' => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => '.',
        ],
    ],
    'weight'        => [
        'default' => Weight::G,
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
            'decimals' => 0,
            'decimal-separator'   => ',',
            'thousands-separator' => '.',
        ],
    ],
];
