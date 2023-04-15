<?php

namespace VampireAPI\Test\Generate;

use CommonRoutes\Generic\ListFactory;
use CommonRoutes\Generic\RecordFactory;
use Faker\Factory as FakerFactory;
use VampireAPI\Generate\NPC;
use PHPUnit\Framework\TestCase;

class NPCTest extends TestCase
{
    private NPC $npc;

    protected function setUp(): void
    {
        $this->npc = new NPC(fakerFactory: new FakerFactory(), listFactory: new ListFactory(), recordFactory: new RecordFactory());
    }

    public function test__construct()
    {
        $this->assertInstanceOf(NPC::class, $this->npc);
    }

    public function testGenerate()
    {
        for ($x = 0; $x < 100; $x++) {
            $result = $this->npc->generate();
            $this->assertIsArray($result);
            $this->assertArrayHasKey('tableTitle', $result);
            $this->assertEquals('NPC BLOCK', $result['tableTitle']);
        }

        // Add more assertions to validate the contents of the generated data
    }
}
