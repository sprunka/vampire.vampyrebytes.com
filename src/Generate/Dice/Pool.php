<?php

namespace VampireAPI\Generate\Dice;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pool extends AbstractRoute
{

    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $type = isset($args['total']) ? ucwords(strtolower($args['total'])) : 10;
        $gender = isset($args['hunger']) ? ucwords(strtolower($args['hunger'])) : 1;
        $laban = isset($args['difficulty']) ? ucwords(strtolower($args['difficulty'])) : 2;
        return parent::outputResponse($response, $this->generate($type, $gender, $laban));
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        //Repurpose $type as Pool Size
        $totalDice = (int) $type;
        // Repurpose $gender as Hunger Level
        $hungerDice = (int) $gender;
        // Repurpose $laban as Difficulty
        $difficulty = (int) ($laban === false ? 2 : $laban);

        $dicePool = $this->rollDice($totalDice, $hungerDice, $difficulty);

        return ['tableTitle' => 'Dice Rolls'] + $dicePool;

    }

    /**
     * Rolls a specified number of total and hunger dice against a difficulty,
     * correcting issues with dice count and success calculation.
     *
     * @param int $totalDice The total number of dice to roll.
     * @param int $hungerDice The number of hunger dice in the total dice pool.
     * @param int $difficulty The difficulty threshold for the roll.
     * @return array The results of the dice roll, including success counts and special conditions.
     */
    function rollDice($totalDice, $hungerDice, $difficulty) {
        $results = [
            'regularResults' => [],
            'hungerResults' => [],
            'totalSuccesses' => 0,
            'criticalSuccesses' => 0,
            'hungerCriticals' => 0,
            'failures' => 0,
            'bestialFailure' => false,
            'messyCritical' => false
        ];

        for ($i = 0; $i < $totalDice; $i++) {
            $roll = rand(1, 10);
            $isHunger = ($i < $hungerDice);

            if ($roll == 10) {
                $results['criticalSuccesses']++;
                if ($isHunger) {
                    $results['hungerCriticals']++;
                }
            }

            if ($roll >= 6) {
                $results['totalSuccesses']++;
            } elseif ($roll == 1 && $isHunger) {
                $results['failures']++;
            }

            if ($isHunger) {
                $results['hungerResults'][] = $roll;
            } else {
                $results['regularResults'][] = $roll;
            }
        }

        // Adjust for critical pairs
        $criticalPairs = intdiv($results['criticalSuccesses'], 2);
        if ($criticalPairs > 0) {
            $results['totalSuccesses'] += $criticalPairs * 2; // Each pair of criticals adds 2 extra successes
        }

        // Determine special conditions
        $results['bestialFailure'] = $results['failures'] > 0 && $results['totalSuccesses'] < $difficulty;
        // Check for messy critical: at least one hunger critical and total successes meet/exceed difficulty
        $results['messyCritical'] = $results['hungerCriticals'] > 0 && $results['totalSuccesses'] >= $difficulty;

        return $results;
    }
}