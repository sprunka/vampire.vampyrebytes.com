<?php

namespace VampireAPI\Generate;

use Faker\Factory;
use Faker\Generator;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use VampireAPI\AbstractRoute;


/**
 *
 */
class Voice extends AbstractRoute
{
    protected Generator $faker;

    public function __construct(Factory $faker)
    {
        $this->faker = $faker::create();
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function __invoke(Request $request, Response $response, array $args = []): Response
    {
        $labanOrAll = strtolower($request->getAttribute('laban'));
        $laban = false;
        if ($labanOrAll === 'yes' || $labanOrAll == '1' || $labanOrAll === 'true' || $labanOrAll === 'laban' || $labanOrAll === 'on') {
            $laban = true;
        }

        return parent::outputResponse($response, $this->generate(laban: $laban));
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        // Base Voice Combos
        $weight = ['No Weight', 'Heavy', 'Light'];
        $spatial = ['Neutral Space', 'Direct', 'Indirect'];
        $timing = ['No Timing', 'Sudden', 'Sustained'];
        $all = [
            'Dabbing - Light, Direct, Sudden',
            'Flicking - Light, Indirect, Sudden',
            'Pressing - Heavy, Direct, Sustained',
            'Floating - Light, Indirect, Sustained',
            'Thrusting - Heavy, Indirect, Sudden',
            'Wringing - Heavy, Indirect, Sustained',
            'Slashing -  Heavy, Direct, Sudden',
            'Gliding - Light, Direct, Sustained',
        ];

        // Add-Ons:
        $addOns = [
            'Air Source' => ['Throaty', 'Nasal', false],
            'Air Variant' => ['Breathy', 'Dry', false],
            'Gender Inclination' => ['Masc', 'Femme', false],
            'Age Variant' => ['Child', false, 'Old'],
            'Body Size' => ['Small', false, 'Large'],
            'Tempo' => ['Slow', false, 'Fast'],
            'Tone' => [false, 'Friendly', 'Aggressive'],
            'Impairments' => [ false, 'Mild','Strong']
        ];

        $addOnsChosen = [];
        foreach ($addOns as $key => $addOn) {
            $pick = rand(0,2);
            if ($addOn[$pick] !== false) {
                $addOnsChosen[$key] = $addOn[$pick];
            }
        }

        if ($laban === false)
            foreach ($weight as $k1 => $w) {
                foreach ($spatial as $k2 => $s) {
                    foreach ($timing as $k3 => $t){
                        $check = $w . ', ' . $s . ', ' . $t;
                        $match = false;
                        foreach ($all as $f) {
                            if (str_contains($f, $check)) {
                                $match = true;
                                break;
                            }
                        }
                        if (!$match) {
                            $all[] = $check;
                        }
                    }
                }
            }

        return [
            'tableTitle' => 'Voice Style',
            'base_voice' => $all[rand(0,count($all)-1)],
            'add_ons' => $addOnsChosen,
        ];
    }
}
