<?php

namespace VampireAPI\Generate\Dice;

use CommonRoutes\AbstractRoute;

class Pool extends AbstractRoute
{

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
     * @param int $totalDice
     * @param int $hungerDice
     * @param int|null $difficulty
     * @return array
     */
    public function rollDice(int $totalDice, int $hungerDice, int|null $difficulty = 2): array
    {
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
            $isHunger = $i < $hungerDice;

            if ($roll == 10) {
                $results['criticalSuccesses']++;
                if ($isHunger) $results['hungerCriticals']++;
            } elseif ($roll == 1 && $isHunger) {
                $results['failures']++;
            } elseif ($roll >= 6) {
                $results['totalSuccesses']++;
            }

            if ($isHunger) {
                $results['hungerResults'][] = $roll;
            } else {
                $results['regularResults'][] = $roll;
            }
        }

        // Calculate total successes, accounting for criticals
        $criticalPairs = intdiv($results['criticalSuccesses'], 2);
        $results['totalSuccesses'] += $criticalPairs * 2; // Each pair of criticals adds 2 extra successes

        // Determine if the roll is a messy critical or bestial failure
        $results['messyCritical'] = $criticalPairs > 0 && $results['hungerCriticals'] > 0 && $results['totalSuccesses'] >= $difficulty;
        $results['bestialFailure'] = $results['failures'] > 0 && $results['totalSuccesses'] < $difficulty;

        return $results;
    }


}