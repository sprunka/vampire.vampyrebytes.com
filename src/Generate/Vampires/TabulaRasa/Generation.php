<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Generation extends AbstractRoute
{

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $modifier = (strtolower($args['modifier']) ?? "1940 to 2005");
        $laban = ($modifier === '2006 to now');

        return parent::outputResponse($response, $this->generate(laban: $laban));
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $modifier = 0;
        if ($laban) {
            $modifier = -4;
        }

        $roll = rand(1, 10) + $modifier;
        if ($roll <= 1) {
            $generation = 'Thin Blood';
        } elseif ($roll <= 5) {
            $generation = '12th or 13th';
        } elseif ($roll <= 7) {
            $generation = '10th or 11th';
        } elseif ($roll == 9) {
            $generation = '9th';
        } else {
            $generation = '8th';
        }

        return [
            'tableTitle' => 'Generation',
            'generation' => $generation,
        ];
    }

}