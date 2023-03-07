<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Skills;

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
        $mentalSkills = [
            1 => 'Academics',
            2 => 'Awareness',
            3 => 'Finance',
            4 => 'Investigation',
            5 => 'Medicine',
            6 => 'Occult',
            7 => 'Politics',
            8 => 'Science',
            9 => 'Technology',
            10 => "Player's Choice",
        ];
        $skill = $mentalSkills[$attributeRoll];

        return [
            'mental_skill' => $skill,
        ];
    }

}
