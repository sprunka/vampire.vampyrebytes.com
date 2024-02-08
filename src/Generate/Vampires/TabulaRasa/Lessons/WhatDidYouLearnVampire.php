<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Lessons;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatDidYouLearnVampire extends AbstractTable
{
    protected array $tableData = [
        'Attributes (3)',
        'Skills (3)',
        'Attribute',
        'Skill',
        'Predator Type',
        'Discipline',
        'Advantage',
        'Flaw',
        'Discipline (2)',
        'roll2x'
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $result = $this->roll();

        if ($result === 'roll2x') {
            $lesson1 = $this->generate();
            $lesson2 = $this->generate();
            $result = $lesson1['what_did_you_learn'] . ', ' . $lesson2['what_did_you_learn'];
        }

        return ['what_did_you_learn' => $result];
    }
}
