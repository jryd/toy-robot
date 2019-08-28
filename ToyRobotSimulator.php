<?php

require 'vendor/autoload.php';

use ToyRobot\Board;
use ToyRobot\Robot;
use ToyRobot\CommandExtractor;

$input = $argv;

// Remove the script name from the input
array_shift($input);

$commands = (new CommandExtractor())->extract($input);

$board = new Board(5,5);
$robot = new Robot($board);

$robot->perform($commands);