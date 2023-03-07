<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhereDidThisHappen extends AbstractTable
{
    protected array $tableData = [
        'Roadside',
        'Social gathering',
        'Secluded area',
        'Government building',
        'Restaurant',
        'Place of work',
        'Place of worship',
        'Retail store',
        'School',
        'Home',
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
        $whereDidItHappen = $this->roll();
        return ['where_did_it_happen' => $whereDidItHappen];
    }
}
