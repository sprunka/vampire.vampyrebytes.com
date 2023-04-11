<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Attributes;

use CommonRoutes\AbstractRoute;

class Physical extends AbstractRoute
{

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
