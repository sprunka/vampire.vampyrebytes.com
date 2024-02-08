<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Attributes;

use CommonRoutes\AbstractRoute;

class Mental extends AbstractRoute
{

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
