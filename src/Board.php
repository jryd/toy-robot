<?php

namespace ToyRobot;

class Board
{
    /**
     * The width of the board.
     *
     * @var integer
     */
    protected $width;

    /**
     * The height of the board.
     *
     * @var integer
     */
    protected $height;

    /**
     * Create a new Board instance
     *
     * @param integer $width
     * @param integer $height
     */
    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Check that the provided x and y coordinates are still
     * within the bounds of the board.
     *
     * @param integer $x
     * @param integer $y
     * @return boolean
     */
    public function isPositionWithinBounds($x, $y)
    {
        return
            (
                $x >= 0 && // $x needs to be greater than or equal to 0, otherwise it is off the board.
                $x < $this->width // $x needs to be less than the width, otherwise it is off the board as the coordinates are zero indexed
            ) &&
            (
                $y >= 0 && // $y needs to be greater than or equal to 0, otherwise it is off the board.
                $y < $this->height // $y needs to be less than the height, otherwise it is off the board as the coordinates are zero indexed
            );
    }
}