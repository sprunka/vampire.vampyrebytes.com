<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class HowDidYouFeel extends AbstractTable
{
    protected array $tableData = [
        'Scared',
        'Angry',
        'Bitter',
        'Content',
        'Nervous',
        'Affection',
        'Cheerful',
        'Despair',
        'Disgust',
        'Confused'
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
        $feelings = $this->roll();
        return ['how_did_you_feel' => $feelings];
    }
}
