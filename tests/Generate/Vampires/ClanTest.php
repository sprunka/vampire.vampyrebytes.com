<?php

namespace VampireAPI\Test\Generate\Vampires;

use VampireAPI\Generate\Vampires\Clan;
use Faker\Factory as FakerFactory;
use PHPUnit\Framework\TestCase;

class ClanTest extends TestCase
{

    protected FakerFactory $fakerFactory;
    protected Clan $clan;

    protected function setUp(): void
    {
        $this->fakerFactory = new FakerFactory();
        $this->clan = new Clan($this->fakerFactory);
    }
    public function testGenerate()
    {
        $iterations = 10000;

        $clans = [
                'Brujah',
                'Gangrel',
                'Ministry',
                'Caitiff',
                'Banu Haqim',
                'Malkavian',
                'Nosferatu',
                'Toreador',
                'Tremere',
                'Ventrue',
                'Hecata',
                'Lasombra',
                'Ravnos',
                'Salubri',
                'Tzimisce',
                'Thin Blood'
        ];

        $sects = [
            'Camarilla',
            'Anarch',
            'Ashira',
            'Independent',
            'Sabbat'
        ];

        for ($i = 0; $i < $iterations; ++$i) {
            $result = $this->clan->generate();

            $this->assertArrayHasKey('tableTitle', $result);
            $this->assertArrayHasKey('sect', $result);
            $this->assertArrayHasKey('clan', $result);

            $this->assertContains($result['sect'], $sects);
            $this->assertContains($result['clan'], $clans);
        }

    }

    public function test__construct()
    {
        $this->assertInstanceOf(Clan::class, $this->clan);
    }
}
