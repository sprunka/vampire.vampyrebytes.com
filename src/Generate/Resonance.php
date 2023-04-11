<?php

namespace VampireAPI\Generate;

use CommonRoutes\AbstractRoute;
use Faker\Factory;
use Faker\Generator;

class Resonance extends AbstractRoute
{
    protected Generator $faker;

    public function __construct(Factory $faker)
    {
        $this->faker = $faker::create();
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $resonance = $this->faker->randomElement([
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Empty',
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic'
        ]);
        return ['tableTitle' => 'Blood Resonance', 'resonance' => $resonance];

    }
}