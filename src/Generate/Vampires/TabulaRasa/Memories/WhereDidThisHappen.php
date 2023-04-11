<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa\Memories;

use VampireAPI\Generate\Vampires\TabulaRasa\AbstractTable;

class WhereDidThisHappen extends AbstractTable
{
    protected array $tableData = [
        'Roadside',
        'Social gathering',
        'Secluded area',
        'Government building',
        'Restaurant',
        'Place of work',
        'Place of worship',
        'Retail store',
        'School',
        'Home',
    ];

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $whereDidItHappen = $this->roll();
        return ['where_did_it_happen' => $whereDidItHappen];
    }
}
