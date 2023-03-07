<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Attributes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

class Social extends AbstractRoute
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
        $socialAttributes = [
            1 => 'Charisma',
            2 => 'Charisma',
            3 => 'Charisma',
            4 => 'Manipulation',
            5 => 'Manipulation',
            6 => 'Manipulation',
            7 => 'Composure',
            8 => 'Composure',
            9 => 'Composure',
            10 => "Player's Choice",
        ];
        $attribute = $socialAttributes[$attributeRoll];

        return [
            'social_attribute' => $attribute,
        ];
    }

}
