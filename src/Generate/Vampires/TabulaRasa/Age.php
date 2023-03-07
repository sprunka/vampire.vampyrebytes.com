<?php

namespace VampireAPI\Generate\Vampires\TabulaRasa;

use DateTime;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use VampireAPI\AbstractRoute;

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
        $type = strtolower($args['type']) ?? 'general';
        return parent::outputResponse($response, $this->generate(type: $type));
    }

    /**
     * @param string $type
     * @param string $gender
     * @param bool $laban
     * @return array
     */
    public function generate($type = 'specific', $gender = '', $laban = false): array
    {
        $ages = [
            '2006 to now', '2006 to now', '2006 to now',
            '1940 to 2005', '1940 to 2005', '1940 to 2005', '1940 to 2005', '1940 to 2005', '1940 to 2005', '1940 to 2005', '1940 to 2005',
            '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940', '1780 to 1940'
        ];

        $specificYears = [
            '2006 to now' => range(2006, date('Y')),
            '1940 to 2005' => range(1940, 2005),
            '1780 to 1940' => range(1780, 1940),
        ];

        $yearRange = $ages[array_rand($ages)];

        if ($type === "specific") {
            $year = $specificYears[$yearRange][array_rand($specificYears[$yearRange])];
            $month = rand(1, 12);
            $daysInMonth = (int) date('t', mktime(0, 0, 0, $month, 1, $year));
            $day = rand(1, $daysInMonth);
            try {
                $birthdate = DateTime::createFromFormat('Y-m-d', "$year-$month-$day");
                $birthdateStr = $birthdate->format('l, F jS, Y \C\E');
            } catch (Exception $e) {
                $birthdateStr = "$year-$month-$day";
            }
            return [
                'range' => $yearRange,
                'exact_date' => $birthdateStr,
            ];
        } elseif ($type === "year") {
            $year = $specificYears[$yearRange][array_rand($specificYears[$yearRange])];
            return [
                'range' => $yearRange,
                'year' => $year,
            ];
        }

        return [
            'range' => $yearRange,
        ];
    }


}
