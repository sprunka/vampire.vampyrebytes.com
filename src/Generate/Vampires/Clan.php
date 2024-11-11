<?php

namespace VampireAPI\Generate\Vampires;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Clan extends AbstractRoute
{
    /**
     * Generate a random clan and sect based on weighted probabilities.
     *
     * @param null $type
     * @param null $gender
     * @param null $laban
     * @return array
     */
    public function generate($type = null, $gender = null, $laban = null): array
    {
        $clan = $this->selectClan();
        $sect = $this->selectSect($clan);

        return [
            'tableTitle' => 'Clan & Sect',
            'sect' => $sect,
            'clan' => $clan,
        ];
    }

    /**
     * Invoke method to handle route request and response.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $args = []
    ): ResponseInterface
    {
        // Generate response content without passing arguments
        $output = $this->generate();

        return $this->outputResponse($response, $output);
    }

    /**
     * @return string
     */
    private function selectClan(): string
    {
        $clanWeights = [
            'Brujah' => 12, 'Gangrel' => 12, 'Ministry' => 6, 'Caitiff' => 8,
            'Banu Haqim' => 4, 'Malkavian' => 8, 'Nosferatu' => 8, 'Toreador' => 10,
            'Tremere' => 10, 'Ventrue' => 12, 'Hecata' => 4, 'Lasombra' => 8,
            'Ravnos' => 2, 'Salubri' => 2, 'Tzimisce' => 2, 'Thin Blood' => 2,
        ];

        return $this->selectByWeight($clanWeights);
    }

    /**
     * @param string $clan
     * @return string
     */
    private function selectSect(string $clan): string
    {
        $sectWeights = [
            'Anarch' => 34, 'Camarilla' => 52, 'Independent' => 12, 'Sabbat' => 2, 'Ashira' => 2,
        ];

        $typicalSects = [
            'Brujah' => 'Anarch', 'Gangrel' => 'Anarch', 'Ministry' => 'Anarch', 'Caitiff' => 'Anarch',
            'Banu Haqim' => 'Camarilla', 'Malkavian' => 'Camarilla', 'Nosferatu' => 'Camarilla',
            'Toreador' => 'Camarilla', 'Tremere' => 'Camarilla', 'Ventrue' => 'Camarilla',
            'Hecata' => 'Independent', 'Lasombra' => 'Independent', 'Ravnos' => 'Independent',
            'Salubri' => 'Independent', 'Tzimisce' => 'Sabbat', 'Thin Blood' => 'Anarch',
        ];

        // Boost the weight of the clan's typical sect
        $typicalSect = $typicalSects[$clan];
        $sectWeights[$typicalSect] += 80;

        return $this->selectByWeight($sectWeights);
    }

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
