<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhatWasHappening extends AbstractTable
{
    protected array $tableData = [
        'Recreation',
        'Tragedy',
        'Working',
        'Intimacy',
        'Dining',
        'Escaping',
        'Planning',
        'Fighting',
        'Relaxing',
        'Creating'
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $whatHappened = $this->roll();
        return ['what_was_happening' => $whatHappened];
    }
}