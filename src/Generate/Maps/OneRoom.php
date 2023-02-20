<?php

namespace VampireAPI\Generate\Maps;

use Faker\Factory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface;
use Faker\Generator;
use VampireAPI\AbstractRoute;
use VampireAPI\Generic\ListFactory;
use VampireAPI\Generic\RecordFactory;
use VampireAPI\Generic\RecordList;
use VampireAPI\Generic\Record;


class OneRoom extends AbstractRoute
{
    protected Generator $faker;
    private RecordList $floorPlan;

    public function __construct(Factory $faker, ListFactory $listFactory, RecordFactory $recordFactory)
    {
        $this->faker = $faker::create();
        $fullList = $listFactory::create();
        $fullList->loadFile(__DIR__ . '/../../../json_src/buildingMaps.json', false);
        $this->floorPlan = $fullList;
    }
    public function __invoke(ServerRequestInterface $request, Response $response, array $args = []): Response
    {
        return parent::outputResponse($response, $this->generate());
    }


    public function generate($type = 'first', $gender = 'any', $laban = false):array
    {
            /** @var Record $floorPlan */
            $floorPlan = $this->floorPlan->current();



        return [
            'name' => $name
        ];
    }

}