<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhoWasWithYou extends AbstractTable
{
    protected array $tableData = [
        'Friend',
        'Sibling / Coterie',
        'Lover',
        'Clerk',
        'Stranger',
        'Enemy / Rival',
        'Mentor',
        'Authority',
        'Parent / Sire',
        'Family / Clan Member'
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $whoWasWithYou = $this->roll();
        return ['who_was_with_you' => $whoWasWithYou];
    }
}
