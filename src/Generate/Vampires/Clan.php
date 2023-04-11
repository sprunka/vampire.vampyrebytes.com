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
        return ['resonance' => $resonance];

    }
}