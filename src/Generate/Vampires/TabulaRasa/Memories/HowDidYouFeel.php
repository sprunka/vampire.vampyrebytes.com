<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class HowDidYouFeel extends AbstractTable
{
    protected array $tableData = [
        'Scared',
        'Angry',
        'Bitter',
        'Content',
        'Nervous',
        'Affection',
        'Cheerful',
        'Despair',
        'Disgust',
        'Confused'
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $feelings = $this->roll();
        return ['how_did_you_feel' => $feelings];
    }
}
