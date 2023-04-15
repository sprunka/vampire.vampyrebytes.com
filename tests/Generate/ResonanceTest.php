<?php

namespace VampireAPI\Test\Generate;

use Faker\Factory;
use VampireAPI\Generate\Resonance;
use PHPUnit\Framework\TestCase;

class ResonanceTest extends TestCase
{
    public Resonance $resonance;

    protected function setUp(): void
    {
        $this->resonance = new Resonance(faker: new Factory());
    }

    public function test__construct()
    {
        $this->assertInstanceOf(Resonance::class, $this->resonance);
    }

    public function testGenerate()
    {
        $result = $this->resonance->generate();

        $this->assertIsArray($result);
        $this->assertArrayHasKey('tableTitle', $result);
        $this->assertArrayHasKey('resonance', $result);
        $this->assertEquals('Blood Resonance', $result['tableTitle']);
        $this->assertContains($result['resonance'], [
            'Sanguine',
            'Melancholic',
            'Choleric',
            'Phlegmatic',
            'Empty'
        ]);
    }
}
