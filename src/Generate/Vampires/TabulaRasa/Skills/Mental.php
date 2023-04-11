<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Skills;

use CommonRoutes\AbstractRoute;

class Mental extends AbstractRoute
{

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
