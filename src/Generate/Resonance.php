<?php

namespace VampireAPI\Generate;

use Faker\Factory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;
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
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic', 'Empty',
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic',
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic',
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic',
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic',
            'Sanguine', 'Melancholic', 'Choleric', 'Phlegmatic'
        ]);
        return ['tableTitle' => 'Blood Resonance', 'resonance' => $resonance];

    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        return parent::outputResponse($response, $this->generate());
    }
}