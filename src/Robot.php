<?php

namespace ToyRobot;

class Robot
{
    /**
     * The x coordinate our robot is currently at.
     *
     * @var integer
     */
    protected $x = null;

    /**
     * The y coordinate our robot is currently at.
     *
     * @var integer
     */
    protected $y = null;

    /**
     * The direction our robot is currently facing.
     *
     * @var string
     */
    protected $direction = null;

    /**
     * A map of the new direction the robot will face when you turn it.
     *
     * @var array
     */
    protected $rotateToNewDirectionMap = [
        "LEFT" => [
            "NORTH" => "WEST",
            "WEST" => "SOUTH",
            "SOUTH" => "EAST",
            "EAST" => "NORTH",
        ],
        "RIGHT" => [
            "NORTH" => "EAST",
            "EAST" => "SOUTH",
            "SOUTH" => "WEST",
            "WEST" => "NORTH"
        ],
    ];

    /**
     * The board our Robot is on.
     *
     * @var \ToyRobot\Board
     */
    protected $board;

    /**
     * Create a new Robot instance.
     *
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * Ask the robot to perform our commands.
     *
     * @param array $commands
     * @return void
     */
    public function perform($commands)
    {
        foreach ($commands as $command) {
            if (!$this->hasBeenPlacedOnBoard() && strpos($command, 'PLACE') === false) {
                continue;
            }

            if (strpos($command, 'PLACE') !== false) {
                $this->place($command);
                continue;
            }

            if ($command === 'MOVE') {
                $this->move();
                continue;
            }

            if ($command === 'LEFT' || $command === 'RIGHT') {
                $this->turn($command);
                continue;
            }

            if ($command === 'REPORT') {
                $this->report();
            }
        }
    }

    /**
     * Place the robot on the board at the supplied coordinates facing the direction we supply.
     *
     * @param string $command
     * @return void
     */
    private function place($command)
    {
        preg_match_all('/\d+,\d+,(NORTH|SOUTH|EAST|WEST)/', $command, $coordinates);
        $coordinates = explode(',', $coordinates[0][0]);

        if (!$this->board->isPositionWithinBounds($coordinates[0], $coordinates[1])) {
            return;
        }

        $this->x = $coordinates[0];
        $this->y = $coordinates[1];
        $this->direction = $coordinates[2];
    }

    /**
     * Ask the robot move one step forward in the direction it is facing.
     *
     * @return void
     */
    private function move()
    {
        $currentX = $this->x;
        $currentY = $this->y;

        if ($this->direction === 'NORTH') {
            $currentY++;
        } else if ($this->direction === 'SOUTH') {
            $currentY--;
        } else if ($this->direction === 'EAST') {
            $currentX++;
        } else {
            $currentX--;
        }

        if (!$this->board->isPositionWithinBounds($currentX, $currentY)) {
            return;
        }

        $this->x = $currentX;
        $this->y = $currentY;
    }

    /**
     * Ask the robot turn 90 degrees in the direction we supply.
     *
     * @param string $direction
     * @return void
     */
    private function turn($direction)
    {
        $this->direction = $this->rotateToNewDirectionMap[$direction][$this->direction];
    }

    /**
     * Ask the robot to report its current position.
     *
     * @return void
     */
    private function report()
    {
        echo sprintf('%d,%d,%s', $this->x, $this->y, $this->direction);
    }

    /**
     * Check if the robot has been placed on the board or not.
     *
     * @return boolean
     */
    public function hasBeenPlacedOnBoard()
    {
        return !is_null($this->x) && !is_null($this->y);
    }
}