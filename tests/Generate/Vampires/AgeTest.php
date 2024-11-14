<?php

namespace VampireAPI\Test\Generate\Vampires;

use VampireAPI\Generate\Vampires\Age;
use PHPUnit\Framework\TestCase;

class AgeTest extends TestCase
{
    protected Age $age;

    protected function setUp(): void
    {
        $this->age = new Age();
    }

    public function testGenerateWithNullType()
    {
        $result = $this->age->generate();
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayNotHasKey('exact_date', $result);
        $this->assertArrayNotHasKey('year', $result);
    }

    public function testGenerateWithSpecificType()
    {
        $result = $this->age->generate('specific');

        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayHasKey('exact_date', $result);
        $this->assertArrayHasKey('year', $result);

        // Validate that 'exact_date' has the expected date format, including possible BCE
        $this->assertMatchesRegularExpression(
            '/^(\w+),\s\w+\s\d{1,2}(st|nd|rd|th),\s(-?\d{1,4})\s(BCE|CE)$/',
            $result['exact_date']
        );

        // Ensure the 'year' falls within the range specified by 'range'
        [$start, $end] = explode(" to ", $result['range']);
        $this->assertGreaterThanOrEqual((int)$start, $result['year']);
        $this->assertLessThanOrEqual((int)$end, $result['year']);
    }

    public function testGenerateWithYearType()
    {
        $result = $this->age->generate('year');
        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayHasKey('year', $result);

        // Check that 'year' is an integer and falls within the full date range
        $this->assertIsInt($result['year']);
        $this->assertGreaterThanOrEqual(-4000, $result['year']);
        $this->assertLessThanOrEqual((int)date('Y'), $result['year']);
    }

    public function testGenerateWithFooType()
    {
        $result = $this->age->generate('foo');
        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayNotHasKey('exact_date', $result);
        $this->assertArrayNotHasKey('year', $result);
    }

    public function testGenerateWithRangeType()
    {
        $result = $this->age->generate('range');
        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
        $this->assertArrayNotHasKey('exact_date', $result);
        $this->assertArrayNotHasKey('year', $result);
    }

    public function testGenerateWithGenderChilder()
    {
        $result = $this->age->generate('range', 'childer');
        $this->assertEquals('Childer', $result['rank']);
    }

    public function testGenerateWithGenderFledgling()
    {
        $result = $this->age->generate('range', 'fledgling');
        $this->assertEquals('Childer', $result['rank']);
    }

    public function testGenerateWithGenderNeonate()
    {
        $result = $this->age->generate('range', 'neonate');
        $this->assertEquals('Neonate', $result['rank']);
    }

    public function testGenerateWithGenderAncilla()
    {
        $result = $this->age->generate('range', 'ancilla');
        $this->assertEquals('Ancilla', $result['rank']);
    }

    public function testGenerateWithGenderElder()
    {
        $result = $this->age->generate('range', 'elder');
        $this->assertEquals('Elder', $result['rank']);
    }

    public function testGenerateWithGenderMethuselah()
    {
        $result = $this->age->generate('range', 'methuselah');
        $this->assertEquals('Methuselah', $result['rank']);
    }

    public function testGenerateWithGenderChoose()
    {
        $result = $this->age->generate('range', 'choose');
        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
    }

    public function testGenerateWithGenderNull()
    {
        $result = $this->age->generate('range', null);
        $this->assertArrayHasKey('rank', $result);
        $this->assertArrayHasKey('range', $result);
    }

    public function testWeightDistribution()
    {
        $iterations = 2500;
        $bracketCounts = [
            'Ancilla' => 0,
            'Neonate' => 0,
            'Childer' => 0,
            'Elder' => 0,
            'Methuselah' => 0,
        ];

        for ($i = 0; $i < $iterations; ++$i) {
            $bracket = $this->age->generate()['rank'];
            $bracketCounts[$bracket]++;
        }

        $expectedRatios = [
            'Ancilla' => 0.40,
            'Neonate' => 0.35,
            'Childer' => 0.15,
            'Elder' => 0.08,
            'Methuselah' => 0.02,
        ];

        foreach ($expectedRatios as $bracket => $ratio) {
            $expectedCount = $ratio * $iterations;
            $tolerance = $expectedCount * 0.2;

            $this->assertGreaterThanOrEqual(
                $expectedCount - $tolerance,
                $bracketCounts[$bracket],
                "Count for {$bracket} is too low"
            );

            $this->assertLessThanOrEqual(
                $expectedCount + $tolerance,
                $bracketCounts[$bracket],
                "Count for {$bracket} is too high"
            );
        }
    }
}
