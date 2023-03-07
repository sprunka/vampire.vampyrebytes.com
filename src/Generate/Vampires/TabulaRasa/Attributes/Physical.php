<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Attributes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Physical extends AbstractRoute
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
        $physicalAttributes = [
            1 => 'Strength',
            2 => 'Strength',
            3 => 'Strength',
            4 => 'Dexterity',
            5 => 'Dexterity',
            6 => 'Dexterity',
            7 => 'Stamina',
            8 => 'Stamina',
            9 => 'Stamina',
            10 => "Player's Choice",
        ];
        $attribute = $physicalAttributes[$attributeRoll];

        return [
            'physical_attribute' => $attribute,
        ];
    }

}
