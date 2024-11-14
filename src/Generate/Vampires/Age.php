<?php

namespace VampireAPI\Generate\Vampires;

use CommonRoutes\AbstractRoute;
use DateTime;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Age extends AbstractRoute
{
    /**
     * @inheritDoc
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface {
        $gender = strtolower($args['age'] ?? null); // Fetch and lower the case for age bracket
        $type = strtolower($args['specificity']) ?? 'general';
        return $this->outputResponse($response, $this->generate(type: $type, gender: $gender));
    }

    /**
     * @param string $type
     * @param string|null $gender
     * @param bool|null $laban
     * @return array
     */
    public function generate($type = 'general', $gender = null, $laban = null): array
    {
        $type = $type ?? 'general';
        $ageBracket = $gender ? ucfirst(strtolower($gender)) : null;

        if (in_array($ageBracket, ['Childer', 'Fledgling'])) {
            $ageBracket = 'Childer';
        }

        if (!$ageBracket || $ageBracket === 'Choose') {
            $ageBracket = $this->selectAgeBracket();
        }

        $specificYears = $this->getYearRangeForBracket($ageBracket);
        $yearRangeStart = min($specificYears);
        $yearRangeEnd = max($specificYears);

        $output = [
            'rank' => $ageBracket,
            'range' => "{$yearRangeStart} to {$yearRangeEnd}"
        ];

        if ($type === 'specific') {
            $date = $this->generateFullDate($specificYears);
            preg_match('/\b(\d{1,4})\s?(BCE|CE)?\b/', $date, $matches);
            $year = isset($matches[1]) ? (int)(($matches[2] === 'BCE' ? -1 : 1) * $matches[1]) : null;
            $output['year'] = $year;
            $output['exact_date'] = $date;
        } elseif ($type === 'year') {
            $year = $specificYears[array_rand($specificYears)];
            $output['year'] = $year;
        }

        return $output;
    }



    /**
     * Selects an age bracket based on weighted probability.
     * @return string
     */
    private function selectAgeBracket(): string
    {
        $bracketWeights = [
            'Ancilla' => 40,   // Most common
            'Neonate' => 35,   // Very common
            'Childer' => 15,   // Less common
            'Elder' => 8,      // Rare
            'Methuselah' => 2, // Ultra rare
        ];

        return $this->selectByWeight($bracketWeights);
    }

    /**
     * Returns an array of years for a given age bracket.
     * @param string $bracket
     * @return array
     */
    private function getYearRangeForBracket(string $bracket): array
    {
        $yearRanges = [
            'Childer' => range(date('Y') - 16, date('Y')),
            'Neonate' => range(1939, date('Y') - 15),
            'Ancilla' => range(1780, 1940),
            'Elder' => range(1000, 1783),  // Assuming 1000 as a lower bound for Elder
            'Methuselah' => range(-4000, 1000),  // "After the Flood" represented as ~4000 BCE
        ];

        return $yearRanges[$bracket] ?? [];
    }

    /**
     * Generates a full date from a specified range of years.
     * @param array $yearRange
     * @return string
     */
    private function generateFullDate(array $yearRange): string
    {
        $year = $yearRange[array_rand($yearRange)];
        $month = rand(1, 12);
        $day = rand(1, (int)date('t', mktime(0, 0, 0, $month, 1, abs($year))));

        try {
            // For BCE dates, format the year accordingly
            $formattedYear = ($year < 0) ? abs($year) . ' BCE' : $year . ' CE';
            $birthdate = DateTime::createFromFormat('Y-m-d', sprintf('%d-%02d-%02d', abs($year), $month, $day));

            // Ensure the format includes BCE or CE as appropriate
            if ($birthdate === false) {
                return "$formattedYear-$month-$day"; // Return in basic format if DateTime fails
            }

            return $birthdate->format("l, F jS, ") . $formattedYear;
        } catch (Exception $e) {
            return "$formattedYear-$month-$day"; // Fallback if DateTime instantiation fails
        }
    }



    /**
     * Selects a key from an array based on weighted probabilities.
     * @param array $weights
     * @return string
     */
    private function selectByWeight(array $weights): string
    {
        $totalWeight = array_sum($weights);
        $randomWeight = rand(1, $totalWeight);
        $cumulativeWeight = 0;

        foreach ($weights as $item => $weight) {
            $cumulativeWeight += $weight;
            if ($randomWeight <= $cumulativeWeight) {
                return $item;
            }
        }

        throw new \RuntimeException("Failed to select an item by weight.");
    }
}
