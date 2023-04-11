<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;

class Predator extends AbstractRoute
{
    const PREDATOR_TYPES = [
        1 => 'Alleycat',
        2 => 'Bagger',
        3 => 'Blood Leech',
        4 => 'Cleaver',
        5 => 'Consensualist',
        6 => 'Farmer',
        7 => 'Osiris',
        8 => 'Sandman',
        9 => 'Scene Queen',
        0 => 'Siren',
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $predatorType = self::PREDATOR_TYPES[array_rand(self::PREDATOR_TYPES)];

        return [
            'tableTitle' => 'Predator Type',
            'predator_type' => $predatorType,
        ];
    }
}

