<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Sect extends AbstractRoute
{

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $modifier = strtolower($args['modifier']) ?? "1940 to 2005";
        $laban = false;
        if ($modifier === '2006 to now') {
            $laban = true;
        }
        return parent::outputResponse($response, $this->generate(laban: $laban));

    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $modifierValue = 0;
        if ($laban) {
            $modifierValue = -4;
        }

        $roll = rand(1, 10) + $modifierValue;

        if ($roll <= 1) {
            $sect = 'Other';
        } elseif ($roll <= 5) {
            $sect = 'Anarch';
        } else {
            $sect = 'Camarilla';
        }

        return [
            'sect' => $sect,
        ];
    }
}