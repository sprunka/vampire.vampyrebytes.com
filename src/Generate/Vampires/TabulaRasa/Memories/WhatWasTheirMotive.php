<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatWasTheirMotive extends AbstractTable
{
    protected array $tableData = [
        'Social violence',
        'Gather Information',
        'Give help',
        'Give information',
        'Physical violence',
        'Ask for help',
        'Seek approval',
        'Demand authority',
        'Negotiate value',
        'Relationship building'
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
        $motive = $this->roll();
        return ['what_was_their_motive' => $motive];
    }
}
