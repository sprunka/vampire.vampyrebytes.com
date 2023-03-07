<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class HowDidItEnd extends AbstractTable
{
    protected array $tableData = [
        'Poorly, feelings were hurt',
        'Poorly, but agreeable',
        'Nothing lost nothing gained',
        'You got what you wanted at a cost',
        'They got what they wanted',
        'Nothing was settled then',
        'Great, both sides felt good',
        'Great, but mildly disappointing',
        'You still don\'t really know',
        'Bitter'
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
        $howDidItEnd = $this->roll();
        return ['how_did_it_end' => $howDidItEnd];
    }
}
