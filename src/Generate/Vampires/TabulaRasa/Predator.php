<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

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

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        return parent::outputResponse($response, $this->generate());
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $predatorType = self::PREDATOR_TYPES[array_rand(self::PREDATOR_TYPES)];

        return [
            'predator_type' => $predatorType,
        ];
    }
}

