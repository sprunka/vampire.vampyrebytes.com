<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Skills;

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
        $socialSkills = [
            1 => 'Animal Ken',
            2 => 'Etiquette',
            3 => 'Insight',
            4 => 'Intimidation',
            5 => 'Leadership',
            6 => 'Performance',
            7 => 'Persuasion',
            8 => 'Streetwise',
            9 => 'Subterfuge',
            10 => "Player's Choice",
        ];
        $skill = $socialSkills[$attributeRoll];

        return [
            'social_skill' => $skill,
        ];
    }

}
