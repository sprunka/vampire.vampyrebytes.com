<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Attributes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Mental extends AbstractRoute
{

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
        $attributeRoll = rand(1, 10);
        $mentalAttributes = [
            1 => 'Intelligence',
            2 => 'Intelligence',
            3 => 'Intelligence',
            4 => 'Wits',
            5 => 'Wits',
            6 => 'Wits',
            7 => 'Resolve',
            8 => 'Resolve',
            9 => 'Resolve',
            10 => "Player's Choice",
        ];
        $attribute = $mentalAttributes[$attributeRoll];

        return [
            'mental_attribute' => $attribute,
        ];
    }

}
