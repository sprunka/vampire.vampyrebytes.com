<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatWasTheirMotive extends AbstractTable
{
    protected array $tableData = [
        'Social violence',
        'Gather Information',
        'Give help',
        'Give information',
        'Physical violence',
        'Ask for help',
        'Seek approval',
        'Demand authority',
        'Negotiate value',
        'Relationship building'
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $motive = $this->roll();
        return ['what_was_their_motive' => $motive];
    }
}
