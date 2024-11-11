<?php

namespace VampireAPI\Test\Generate;

use VampireAPI\Generate\Resonance;
use PHPUnit\Framework\TestCase;

class ResonanceTest extends TestCase
{
    protected Resonance $resonance;

    protected function setUp(): void
    {
        $this->resonance = new Resonance();
    }

    public function testGenerateStructure()
    {
        $result = $this->resonance->generate();

        // Verify output structure
        $this->assertArrayHasKey('tableTitle', $result);
        $this->assertArrayHasKey('temperament', $result);
        $this->assertArrayHasKey('resonance', $result);

        // Verify data types
        $this->assertIsString($result['tableTitle']);
        $this->assertIsString($result['temperament']);
        $this->assertIsString($result['resonance']);
    }

    public function testTemperamentAndResonancePresence()
    {
        $iterations = 1000;
        $temperamentResults = [
            'Well-balanced, negligible' => 0,
            'Fleeting' => 0,
            'Intense' => 0,
            'Acute' => 0,
        ];

        $resonanceResults = [
            'Phlegmatic' => 0,
            'Melancholic' => 0,
            'Choleric' => 0,
            'Sanguine' => 0,
        ];

        // Run multiple iterations to ensure all options appear in results
        for ($i = 0; $i < $iterations; $i++) {
            $result = $this->resonance->generate();

            // Count occurrences of each temperament and resonance
            $temperamentResults[$result['temperament']]++;
            $resonanceResults[$result['resonance']]++;
        }

        // Assert that each temperament was generated at least once
        foreach ($temperamentResults as $temperament => $count) {
            $this->assertGreaterThan(0, $count, "Temperament '{$temperament}' was not generated.");
        }

        // Assert that each resonance was generated at least once
        foreach ($resonanceResults as $resonance => $count) {
            $this->assertGreaterThan(0, $count, "Resonance '{$resonance}' was not generated.");
        }
    }
}
