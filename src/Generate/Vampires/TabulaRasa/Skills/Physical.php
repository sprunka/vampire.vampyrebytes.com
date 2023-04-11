<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Skills;

use CommonRoutes\AbstractRoute;

class Physical extends AbstractRoute
{

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $attributeRoll = rand(1, 10);
        $physicalSkills = [
            1 => 'Athletics',
            2 => 'Brawl',
            3 => 'Craft',
            4 => 'Drive',
            5 => 'Firearms',
            6 => 'Melee',
            7 => 'Larceny',
            8 => 'Stealth',
            9 => 'Survival',
            10 => "Player's Choice",
        ];
        $skill = $physicalSkills[$attributeRoll];

        return [
            'physical_skill' => $skill,
        ];
    }

}
