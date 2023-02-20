<?php

namespace VampireAPI\Generate;

use Faker\Factory;
use Faker\Generator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Occupation extends AbstractRoute
{
    private Generator $faker;

    public function __construct(Factory $fakerFactory)
    {
        $this->faker = $fakerFactory::create();
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $occupation = $this->faker->jobTitle;
        return ['occupation' => $occupation];
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        return parent::outputResponse($response, $this->generate());
    }
}
