<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ToyRobot\CommandExtractor;

class CommandExtractorTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->commandExtractor = new CommandExtractor();
    }

    /** @test */
    public function the_command_extractor_can_parse_commands_as_input_arguments()
    {
        $commands = $this->commandExtractor->extract(['PLACE 0,0,NORTH', 'MOVE', 'REPORT']);

        $this->assertEquals([
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT'
        ], $commands);
    }

    /** @test */
    public function the_command_extractor_can_parse_commands_from_a_file()
    {
        $commands = $this->commandExtractor->extract([__DIR__ . '/stubs/testCaseA.txt']);

        $this->assertEquals([
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT'
        ], $commands);

        $commands = $this->commandExtractor->extract([__DIR__ . '/stubs/testCaseB.txt']);

        $this->assertEquals([
            'PLACE 0,0,NORTH',
            'LEFT',
            'REPORT'
        ], $commands);

        $commands = $this->commandExtractor->extract([__DIR__ . '/stubs/testCaseC.txt']);

        $this->assertEquals([
            'PLACE 1,2,EAST',
            'MOVE',
            'MOVE',
            'LEFT',
            'MOVE',
            'REPORT'
        ], $commands);
    }

    /** @test */
    public function a_partial_command_is_ignored_by_the_command_extractor()
    {
        $commands = $this->commandExtractor->extract(['PLACE 0,0,NORTH', 'MOVE', 'MOVEMOVE', 'REPORT']);

        $this->assertEquals([
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT'
        ], $commands);
    }
}