# Toy Robot Simulator
The application is a simulation of a toy robot moving on a square tabletop, of dimensions 5 units x 5 units.

## Installation
1. Clone the repository; `git clone https://github.com/jryd/toy-robot-simulator.git`
2. Install the dependencies; `composer install`
3. Voila! You're good to go

## Execution

You can provide the robot with a valid set of commands for it to perform.
The valid commands are:
* `PLACE X,Y,DIRECTION`
  * `X` is the x coordinate on the board
  * `Y` is the y coordidate on the board
  * `DIRECTION` is the direction the robot should be facing, valid values:
    * `NORTH`
    * `SOUTH`
    * `EAST`
    * `WEST`
  * NOTE: your x and y coordinates must be valid coordinates within the bounds of the board, otherwise the robot will ignore the command
* `MOVE` - move the robot forward in the direction it is facing
* `LEFT` - turn the robot to face 90 degrees to the left
* `RIGHT` - turn the robot to face 90 degrees to the right
* `REPORT` - output the current position of the robot

The robot must first be placed on the board before you can ask it to perform any other commands. Any commands provided before placing the robot **will be ignored**.

### Examples

#### Via Standard Input

``` bash
php ToyRobotSimulator.php PLACE 0,0,NORTH MOVE REPORT
Output - 0,1,NORTH
```

#### Via a Text File
``` bash
php ToyRobotSimulator.php test.txt
Output - 1,3,WEST
```

## Testing

Run the automated tests with:

``` bash
./vendor/bin/phpunit
```

### Example Inputs and Outputs

#### A
Input:
```
PLACE 0,0,NORTH
MOVE
REPORT
```

Output:
```
0,1,NORTH
```

#### B
Input:
```
PLACE 0,0,NORTH
LEFT
REPORT
```

Output:
```
0,0,WEST
```

#### C
Input:
```
PLACE 1,2,EAST
MOVE
MOVE
LEFT
MOVE
REPORT
```

Output:
```
3,3,NORTH
```

## Design Decisions and Assumptions

I've broken the logic of the challenge down into 3 specific areas; the board, the robot, and the command parser.
Each of these areas is represented as a class which contains all the variables and methods needed for it to operate correctly.

I have made the assumption that the requirements are fixed and aren't going to change. For that reason I have not used interfaces, however if the requirements had the possibility of changing, it may be worth implementing interfaces to ensure we can swap out any of the classes and still have confidence that we can call certain methods.

### Board
* The board is able to accept a configurable board size, allowing this to be changed in future if needed
* The board is able to validate whether given coordinates are inside the bounds of it, this is really the job of the board - not the robot; the robot just wants to know whether it is stepping off the board or not

### Command Parser
* The command parser is able to detect if the input is a readable file or is standard input
* The constraints of the challenge specify that these are the only two options to provide input (and I have assumed this won't change), however the current implementation does violate the single responsibility principle as this class will need to change if the valid list of commands changes or a new input type is needed.
  An alternative solution to this would be to have the command parser accept the string of commands and have the caller be responsible for getting the commands.
  Given my assumption that the constraints of the challenge won't change, I am happy tucking this logic into this class for now
* By using a `preg_match_all` we can be pretty flexible on the input format (i.e you can space separate or new line separate the commands and it will still work) and only extract the valid commands we want as per the regex

### Robot
* The robot can place itself on the board, but will check that the coordinates you want to place it are valid before doing so
* The `LEFT` and `RIGHT` commands are essentially performing the same action, it is just the direction you are turning that changes.
  Using a map of the direction you want to turn and your current position, we can clearly see what new direction we expect to be facing
* As `PLACE X,Y,DIRECTION` is always a valid command, our robot supports being able to be re-placed on the board
