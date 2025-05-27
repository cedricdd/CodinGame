# Puzzle
**Exolegend: Bomberman** https://www.codingame.com/contribute/view/124953e71d9380e70bf3527d2b3b2d71e0bf94

# Goal
In this game, you control a robot in a maze. The goal is to collect bombs and use them to paint the ground.  
The maze consists of 6 rows and 10 columns. You must guide your robot to pick up bombs, drop them in the maze, then flee to avoid the explosion. When a bomb explodes, it colors the tile it's on and 1 tile in each direction in a cross pattern, as long as the direction isn’t blocked by a wall.  
Each collected bomb gives 1 point, and each colored tile also gives 1 point.  

To win, you need to reach the required number of points, shown in the top left of the screen, without crashing into a wall or getting caught in an explosion.  

*Victory Conditions*  
* You reach the required number of points.

*Defeat Conditions*  
* The robot crashes into a wall.
* The robot is caught in a bomb explosion.
* You don’t reach the required points within 200 turns.
* You fail to respond in time or the command is unknown.

# Initialization Input  
- Line 1: An integer: rows, representing the number of rows in the maze.
- Line 2: An integer: columns, representing the number of columns in the maze.
- Then, one line per cell of the maze, each containing 5 space-separated boolean: west, east, north, south, and hasBomb.

These values indicate the presence of walls in each direction and whether a bomb is present in the cell.

# Turn Input
-Line 1: 4 space-separated integers: robotX, robotY, robotA, and robotBombs.

These values represent the current position of the robot, its orientation, and the number of bombs it is carrying.

The orientation robotA is defined as follows:  
* 0 → facing WEST
* 1 → facing EAST
* 2 → facing NORTH
* 3 → facing SOUTH

# Output
Print one of the following actions:  
* MOVE_FORWARD : Moves the robot forward by one cell. If it hits a wall, it will crash.
* MOVE_BACKWARD : Moves the robot backward by one cell. If it hits a wall, it will crash.
* TURN_LEFT : Rotates the robot 90° to the left (counterclockwise).
* TURN_RIGHT : Rotates the robot 90° to the right (clockwise).
* DROP : Drops a bomb in the current cell, if the robot has at least one and no bomb is already present.
* WAIT : Waits for the next turn. 

# Constraints
* 0 ≤ robotX < 10
* 0 ≤ robotY < 6
* 0 ≤ robotA ≤ 3
* 0 ≤ robotBombs
