<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;
use VampireAPI\Generate\Vampires\TabulaRasa\Lessons\WhatDidYouLearnHuman;
use VampireAPI\Generate\Vampires\TabulaRasa\Lessons\WhatDidYouLearnVampire;

class Lesson extends AbstractRoute
{

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = strtolower($args['type']) ?? 'mortal';
        return parent::outputResponse($response, $this->generate(type: $type));

    }

    public function generate($type = 'mortal', $gender = '', $laban = false): array
    {
        $lesson = match ($type) {
            'kindred' => new WhatDidYouLearnVampire(),
            default => new WhatDidYouLearnHuman(),
        };

        return $lesson->generate();
    }
}