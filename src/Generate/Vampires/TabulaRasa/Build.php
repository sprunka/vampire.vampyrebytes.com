<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use CommonRoutes\AbstractRoute;
use CommonRoutes\Generic\ListFactory;
use CommonRoutes\Generic\RecordFactory;
use Faker\Factory;
use VampireAPI\Generate\NPC;

class Build extends AbstractRoute
{
    protected Factory $fakerFactory;
    protected ListFactory $listFactory;
    protected RecordFactory $recordFactory;

    public function __construct(Factory $fakerFactory, ListFactory $listFactory, RecordFactory $recordFactory)
    {
        $this->fakerFactory = $fakerFactory;
        $this->listFactory = $listFactory;
        $this->recordFactory = $recordFactory;
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $npc = new NPC(
            fakerFactory: $this->fakerFactory,
            listFactory: $this->listFactory,
            recordFactory: $this->recordFactory
        );
        $npcBlock = $npc->generate();
        $ageRange = (new Age())->generate(type: 'specific');
        $age_range = $ageRange['range'];
        $modifier = ($age_range === '2006 to now');

        $generation = (new Generation())->generate(laban: $modifier);
        $sect = (new Sect())->generate(laban: $modifier);
        $clan = (new Clan())->generate(type: $sect['sect']);

        return [
            'tableTitle' => 'Full Base Vampire. Generate Memories and Lessons until you have a complete character.',
            'mortal_characteristics' => $npcBlock,
            'vampire_details' => [
                'embrace' => array_merge($ageRange, $generation),
                'blood' => array_merge($sect, $clan)
            ]
        ];
    }
}