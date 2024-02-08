<?php

namespace VampireAPI\Generate\Vampires;

use CommonRoutes\AbstractRoute;
use Faker\Factory;
use Faker\Generator;

class Clan extends AbstractRoute
{
    protected Generator $faker;

    public function __construct(Factory $faker)
    {
        $this->faker = $faker::create();
    }

    public function generate($type = 'anarch', $gender = '', $laban = false): array
    {
        $roll = rand(1, 110);

        if ($roll <= 12) {
            $clan = 'Brujah';
        } elseif ($roll <= 24) {
            $clan = 'Gangrel';
        } elseif ($roll <= 30) {
            $clan = 'Ministry';
        } elseif ($roll <= 38) {
            $clan = 'Caitiff';
        } elseif ($roll <= 42) {
            $clan = 'Banu Haqim';
        } elseif ($roll <= 50) {
            $clan = 'Malkavian';
        } elseif ($roll <= 58) {
            $clan = 'Nosferatu';
        } elseif ($roll <= 68) {
            $clan = 'Toreador';
        } elseif ($roll <= 78) {
            $clan = 'Tremere';
        } elseif ($roll <= 90) {
            $clan = 'Ventrue';
        } elseif ($roll <= 94) {
            $clan = 'Hecata';
        } elseif ($roll <= 102) {
            $clan = 'Lasombra';
        } elseif ($roll <= 104) {
            $clan = 'Ravnos';
        } elseif ($roll <= 106) {
            $clan = 'Salubri';
        } elseif ($roll <= 108) {
            $clan = 'Tzimisce';
        } else {
            $clan = 'Thin Blood';
        }

        $sectWeights = [
            'Anarch' => 34,
            'Camarilla' => 52,
            'Independent' => 12,
            'Sabbat' => 2,
            'Ashira' => 2
        ];

        $typicalSects = [
            'Brujah' => 'Anarch',
            'Gangrel' => 'Anarch',
            'Ministry' => 'Anarch',
            'Caitiff' => 'Anarch',
            'Banu Haqim' => 'Camarilla',
            'Malkavian' => 'Camarilla',
            'Nosferatu' => 'Camarilla',
            'Toreador' => 'Camarilla',
            'Tremere' => 'Camarilla',
            'Ventrue' => 'Camarilla',
            'Hecata' => 'Independent',
            'Lasombra' => 'Independent',
            'Ravnos' => 'Independent',
            'Salubri' => 'Independent',
            'Tzimisce' => 'Sabbat',
            'Thin Blood' => 'Anarch'
        ];

        $typicalSect = $typicalSects[$clan];
        $sectWeights[$typicalSect] += 80; // Add 80 to the typical sect weight

        // Calculate the sum of weights
        $totalWeight = array_sum($sectWeights);

        // Generate a random number between 1 and the sum of weights
        $randomWeight = rand(1, $totalWeight);

        // Determine the sect based on the random weight
        $cumulativeWeight = 0;
        foreach ($sectWeights as $sectHold => $weight) {
            $cumulativeWeight += $weight;
            if ($randomWeight <= $cumulativeWeight) {
                $sect = $sectHold;
                break;
            }
        }

        return [
            'tableTitle' => 'Clan & Sect',
            'sect' => $sect,
            'clan' => $clan,
        ];
    }

}