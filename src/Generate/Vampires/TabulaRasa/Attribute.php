<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\Attributes\Mental;
use VampireAPI\Generate\Vampires\TabulaRasa\Attributes\Physical;
use VampireAPI\Generate\Vampires\TabulaRasa\Attributes\Social;

class Attribute extends AbstractRoute
{

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = strtolower($args['type'] ?? 'rand');

        if ($type === 'rand') {
            $choice = rand(1, 10);
            if ($choice === 10) {
                $returnArray = ['any_attribute' => 'Player\'s Choice'];
                return parent::outputResponse($response, $returnArray);
            }
            $type = match ($choice) {
                1, 2, 3 => 'physical',
                4, 5, 6 => 'social',
                default => 'mental',
            };
        }

        return parent::outputResponse($response, $this->generate(type: $type));
    }

    public function generate($type = 'physical', $gender = '', $laban = false): array
    {
        $return = match ($type) {
            'mental' => (new Mental())->generate(),
            'social' => (new Social())->generate(),
            default => (new Physical())->generate(),
        };
        return ['tableTitle' => 'Attribute'] + $return;
    }
}