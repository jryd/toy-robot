<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use ToyRobot\Board;

class BoardTest extends TestCase
{
    /** @test */
    public function a_board_of_five_by_five_can_indicate_if_a_position_within_bounds()
    {
        $board = new Board(5,5);

        $this->assertTrue($board->isPositionWithinBounds(0,0));
        $this->assertTrue($board->isPositionWithinBounds(1,1));
        $this->assertTrue($board->isPositionWithinBounds(2,2));
        $this->assertTrue($board->isPositionWithinBounds(3,3));
        $this->assertTrue($board->isPositionWithinBounds(4,4));
    }

    /** @test */
    public function a_borad_of_five_by_five_can_indicate_if_a_position_is_out_of_bounds()
    {
        $board = new Board(5,5);

        $this->assertFalse($board->isPositionWithinBounds(-1, -1));
        $this->assertFalse($board->isPositionWithinBounds(-1, 2));
        $this->assertFalse($board->isPositionWithinBounds(2, -1));
        $this->assertFalse($board->isPositionWithinBounds(5, 5));
    }

    /** @test */
    public function a_board_can_handle_a_variable_width_and_height_and_still_indicate_if_the_position_is_within_bounds()
    {
        $board = new Board(7,3);

        $this->assertTrue($board->isPositionWithinBounds(0,0));
        $this->assertTrue($board->isPositionWithinBounds(1,1));
        $this->assertTrue($board->isPositionWithinBounds(6,2));
    }

    /** @test */
    public function a_board_can_handle_a_variable_width_and_height_and_still_indicate_if_the_position_is_outside_of_the_bounds()
    {
        $board = new Board(4,8);

        $this->assertFalse($board->isPositionWithinBounds(-1,-1));
        $this->assertFalse($board->isPositionWithinBounds(4,8));
        $this->assertFalse($board->isPositionWithinBounds(10,10));
    }
}