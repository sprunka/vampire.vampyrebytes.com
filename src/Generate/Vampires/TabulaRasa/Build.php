<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use Faker\Factory;
use Faker\Generator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\Generate\NPC;
use VampireAPI\Generic\ListFactory;
use VampireAPI\Generic\RecordFactory;

class Build extends \VampireAPI\AbstractRoute
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

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        return parent::outputResponse($response, $this->generate());
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