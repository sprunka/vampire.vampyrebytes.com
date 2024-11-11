<?php

namespace VampireAPI\Generate;

use CommonRoutes\AbstractRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Resonance extends AbstractRoute
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args = []): ResponseInterface
    {
        // Generate output for the response
        $output = $this->generate();
        return $this->outputResponse($response, $output);
    }

    public function generate($type = '', $gender = '', $laban = false): array
    {
        $temperament = $this->generateTemperament();
        $resonance = $this->generateResonance();

        return [
            'tableTitle' => 'Blood Resonance',
            'temperament' => $temperament,
            'resonance' => $resonance,
        ];
    }

    private function generateTemperament(): string
    {
        $roll = $this->rollDice(10);

        if ($roll <= 5) {
            return 'Well-balanced, negligible';
        } elseif ($roll <= 8) {
            return 'Fleeting';
        } else {
            return $this->determineIntensity();
        }
    }

    private function determineIntensity(): string
    {
        $intensityRoll = $this->rollDice(10);
        return $intensityRoll <= 8 ? 'Intense' : 'Acute';
    }

    private function generateResonance(): string
    {
        $roll = $this->rollDice(10);

        return match (true) {
            $roll <= 3 => 'Phlegmatic',
            $roll <= 6 => 'Melancholic',
            $roll <= 8 => 'Choleric',
            default => 'Sanguine',
        };
    }

    private function rollDice(int $sides): int
    {
        return random_int(1, $sides);
    }
}
