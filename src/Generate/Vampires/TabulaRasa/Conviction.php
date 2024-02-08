<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;

class Conviction extends AbstractRoute
{
    const TABLE_ONE = [
        1 => 'Faith',
        2 => 'Charity',
        3 => 'Fortitude',
        4 => 'Murder',
        5 => 'Hope',
        6 => 'Gluttony',
        7 => 'Justice',
        8 => 'Greed',
        9 => 'Honor',
        0 => 'Lust',
    ];

    const TABLE_TWO = [
        1 => 'Temperance',
        2 => 'Pride',
        3 => 'Love',
        4 => 'Wrath',
        5 => 'Freedom',
        6 => 'Enslavement',
        7 => 'Protect',
        8 => 'Truth',
        9 => 'Obedience',
        0 => 'Vows',
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $table = rand(1, 2);
        $conviction = ($table === 1) ? self::TABLE_ONE[array_rand(self::TABLE_ONE)] : self::TABLE_TWO[array_rand(self::TABLE_TWO)];
        $frequencyRoll = rand(1, 10);
        $frequency = match ($frequencyRoll) {
            1, 2 => 'Always',
            3, 4 => 'Always for a specific group',
            5 => 'Always for a specific action',
            6, 7 => 'Never',
            8, 9 => 'Never for a specific group',
            default => 'Never for a specific action',
        };
        return [
            'tableTitle' => 'Conviction Data',
            'ethic' => $conviction,
            'frequency' => $frequency,
        ];
    }
}
