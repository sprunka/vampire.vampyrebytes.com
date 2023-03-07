<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhoWasWithYou extends AbstractTable
{
    protected array $tableData = [
        'Friend',
        'Sibling / Coterie',
        'Lover',
        'Clerk',
        'Stranger',
        'Enemy / Rival',
        'Mentor',
        'Authority',
        'Parent / Sire',
        'Family / Clan Member'
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
        $whoWasWithYou = $this->roll();
        return ['who_was_with_you' => $whoWasWithYou];
    }
}
