<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ToyRobot\Board;
use ToyRobot\Robot;

class RobotTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->board = new Board(5,5);
    }

    /** @test */
    public function a_robot_can_complete_test_case_a()
    {
        $robot = new Robot($this->board);

        // Test case A
        $commands = [
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT'
        ];

        $this->expectOutputString('0,1,NORTH');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_can_complete_test_case_b()
    {
        $robot = new Robot($this->board);

        // Test case B
        $commands = [
            'PLACE 0,0,NORTH',
            'LEFT',
            'REPORT'
        ];

        $this->expectOutputString('0,0,WEST');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_can_complete_test_case_c()
    {
        $robot = new Robot($this->board);

        // Test case C
        $commands = [
            'PLACE 1,2,EAST',
            'MOVE',
            'MOVE',
            'LEFT',
            'MOVE',
            'REPORT',
        ];

        $this->expectOutputString('3,3,NORTH');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_will_ignore_any_commands_before_the_place_command()
    {
        $robot = new Robot($this->board);

        $commands = [
            'MOVE',
            'LEFT',
            'RIGHT',
            'PLACE 0,0,NORTH',
            'MOVE',
            'REPORT'
        ];

        $this->expectOutputString('0,1,NORTH');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_will_ignore_a_move_command_if_it_would_cause_the_robot_to_fall_off_the_table()
    {
        $robot = new Robot($this->board);

        $commands = [
            'PLACE 4,4,NORTH', // We have a 5 x 5 grid, so if we set the x and y to 4 and 4, this will put us at the top right corner facing north
            'MOVE',
            'RIGHT',
            'MOVE',
            'REPORT'
        ];

        $this->expectOutputString('4,4,EAST');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_can_be_placed_again_after_being_placed_and_continue_movements_from_there()
    {
        $robot = new Robot($this->board);

        $commands = [
            'PLACE 0,0,NORTH',
            'MOVE',
            'MOVE',
            'MOVE', // We are now at 0,3,NORTH
            'PLACE 0,0,NORTH',
            'REPORT'
        ];

        $this->expectOutputString('0,0,NORTH');

        $robot->perform($commands);
    }

    /** @test */
    public function a_robot_will_ignore_all_commands_until_a_valid_place_command_is_given()
    {
        $robot = new Robot($this->board);

        $commands = [
            'PLACE 5,5,NORTH', // invalid place command as this would put the robot outside the bounds of our 5 x 5 grid
            'MOVE',
            'MOVE',
            'MOVE', // We are now at 0,3,NORTH
            'REPORT'
        ];

        $this->expectOutputString('');

        $robot->perform($commands);
    }
}