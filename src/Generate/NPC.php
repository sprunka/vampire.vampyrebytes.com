<?php

namespace VampireAPI\Generate;

use Faker\Factory;
use Faker\Generator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use VampireAPI\AbstractRoute;
use CommonRoutes\Generate\Gender;
use CommonRoutes\Generate\Name;
use CommonRoutes\Generate\PhysicalDescription;
use CommonRoutes\Generate\Occupation;
use CommonRoutes\Generate\Voice;
use CommonRoutes\Generic\ListFactory;
use CommonRoutes\Generic\RecordFactory;


class NPC extends AbstractRoute
{
    protected Generator $faker;
    protected Factory $fakerFactory;
    protected ListFactory $listFactory;
    protected RecordFactory $recordFactory;

    public function __construct(Factory $fakerFactory, ListFactory $listFactory, RecordFactory $recordFactory)
    {
        $this->fakerFactory = $fakerFactory;
        $this->faker = $fakerFactory::create();
        $this->listFactory = $listFactory;
        $this->recordFactory = $recordFactory;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []) : Response
    {
        return parent::outputResponse($response, $this->generate());
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $genderArr = (new Gender($this->fakerFactory))->generate();
        $tempGenderArray = array_flip(array_flip($genderArr));
        $genderText = $tempGenderArray['gender'];

        $tempGender = 'neutral';
        if ((strtolower($genderText) === 'male') || (strtolower($genderText) === 'female')) {
            $tempGender = $genderText;
        }

        $name = (new Name($this->fakerFactory, $this->listFactory, $this->recordFactory))->generate(type: 'full', gender: $tempGender);

        $physical = (new PhysicalDescription($this->fakerFactory))->generate(gender: $tempGender);

        $occupation = (new Occupation($this->fakerFactory))->generate();

        $resonance = (new Resonance($this->fakerFactory))->generate();

        $laban = ( rand(1,2) % 2 === 0 );
        $voice = (new Voice($this->fakerFactory))->generate(laban: $laban);

        $return = array_merge($name, $genderArr, $occupation, $physical, $resonance, ['vocal_tips' => $voice]);
        return ['tableTitle' => 'NPC BLOCK'] + $return;

        //return array_merge(['tableTitle'=>'NPC BLOCK'], $name, $genderArr, $occupation, $physical, $resonance, ['vocal_tips' => $voice]);
    }
}