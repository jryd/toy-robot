<?php

namespace ToyRobot;

class CommandExtractor
{
    /**
     * Extract the valid commands from the provided
     * input or file.
     *
     * @param array $arguments
     * @return array
     */
    public function extract($arguments)
    {
        $commands = null;

        if (is_file($arguments[0]) && is_readable($arguments[0])) {
            $commands = file_get_contents($arguments[0]);
        }
        else {
            $commands = implode(' ', $arguments);
        }

        preg_match_all('/\b(PLACE \d+,\d+,(NORTH|SOUTH|EAST|WEST))\b|\bMOVE\b|\bLEFT\b|\bRIGHT\b|\bREPORT\b/', $commands, $matches);

        return $matches[0]; // Index 0 contains an array of strings that matched the full pattern
    }
}