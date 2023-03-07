<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatWasHappening extends AbstractTable
{
    protected array $tableData = [
        'Recreation',
        'Tragedy',
        'Working',
        'Intimacy',
        'Dining',
        'Escaping',
        'Planning',
        'Fighting',
        'Relaxing',
        'Creating'
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
        $whatHappened = $this->roll();
        return ['what_was_happening' => $whatHappened];
    }
}