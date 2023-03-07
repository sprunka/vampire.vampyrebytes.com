<?php


namespace VampireAPI\Generate\Vampires\TabulaRasa\Lessons;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatDidYouLearnHuman extends AbstractTable
{
    protected array $tableData = [
        'Attributes (3)',
        'Skill (3)',
        'Attribute',
        'Skill',
        'A conviction',
        'Skills (2)',
        'Attributes (3) + Skill',
        'Skills (3) + Attirbute',
        'Conviction + Attribute',
        'Convction + Attribute + Skill'
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
        $whatLearned = $this->roll();
        return ['what_did_you_learn' => $whatLearned];
    }
}
