<?php

namespace VampireAPI\Test\Generate\Vampires;

use VampireAPI\Generate\Vampires\Clan;
use Faker\Factory as FakerFactory;
use PHPUnit\Framework\TestCase;

class ClanTest extends TestCase
{
    protected Clan $clan;

    protected function setUp(): void
    {
        $fakerFactory = new FakerFactory();
        $this->clan = new Clan($fakerFactory);
    }

    public function testGenerate()
    {
        // Even at 10k iterations, some distributions may fall outside the Tolerance range, especially at the low and high weights.
        $iterations = 10000;
        $results = [
            'clans' => [],
            'sects' => []
        ];

        // Define expected clans and sects
        $expectedClans = [
            'Brujah' => 12, 'Gangrel' => 12, 'Ministry' => 6, 'Caitiff' => 8,
            'Banu Haqim' => 4, 'Malkavian' => 8, 'Nosferatu' => 8, 'Toreador' => 10,
            'Tremere' => 10, 'Ventrue' => 12, 'Hecata' => 4, 'Lasombra' => 8,
            'Ravnos' => 2, 'Salubri' => 2, 'Tzimisce' => 2, 'Thin Blood' => 2,
        ];

        $expectedSects = [
            'Anarch' => 34, 'Camarilla' => 52, 'Independent' => 12, 'Sabbat' => 2, 'Ashira' => 2,
        ];

        // Run multiple iterations to test both presence and weighted distribution
        for ($i = 0; $i < $iterations; ++$i) {
            $result = $this->clan->generate();

            // Presence checks
            $this->assertArrayHasKey('tableTitle', $result);
            $this->assertArrayHasKey('sect', $result);
            $this->assertArrayHasKey('clan', $result);

            $this->assertArrayHasKey($result['sect'], $expectedSects, "Invalid sect generated");
            $this->assertArrayHasKey($result['clan'], $expectedClans, "Invalid clan generated");

            // Track occurrences for distribution verification
            $results['clans'][$result['clan']] = ($results['clans'][$result['clan']] ?? 0) + 1;
            $results['sects'][$result['sect']] = ($results['sects'][$result['sect']] ?? 0) + 1;
        }

        // Verify distribution for clans and sects
        $this->verifyDistribution($results['clans'], $iterations, $expectedClans, "clan");
        $this->verifyDistribution($results['sects'], $iterations, $expectedSects, "sect");
    }

    private function verifyDistribution(array $results, int $iterations, array $expectedWeights, string $type): void
    {
        $totalWeight = array_sum($expectedWeights);

        foreach ($expectedWeights as $key => $weight) {
            $expectedCount = $iterations * ($weight / $totalWeight);

            // Adjust tolerance dynamically: higher for lower weights
            $toleranceFactor = $weight < 5 ? 0.5 : 0.25; // 50% for low-weight categories, 25% otherwise
            $tolerance = $expectedCount * $toleranceFactor;

            $min = $expectedCount - $tolerance;
            $max = $expectedCount + $tolerance;

            $this->assertGreaterThanOrEqual(
                $min,
                $results[$key] ?? 0,
                "Distribution for {$type} '{$key}' is too low. Expected ~{$expectedCount}, got " . ($results[$key] ?? 0) . "."
            );
            $this->assertLessThanOrEqual(
                $max,
                $results[$key] ?? 0,
                "Distribution for {$type} '{$key}' is too high. Expected ~{$expectedCount}, got " . ($results[$key] ?? 0) . "."
            );
        }
    }

    public function test__construct()
    {
        $this->assertInstanceOf(Clan::class, $this->clan);
    }
}
