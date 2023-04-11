<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Skills;

use CommonRoutes\AbstractRoute;

class Social extends AbstractRoute
{

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
