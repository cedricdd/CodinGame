# Puzzle
**Maze** https://www.codingame.com/training/medium/maze

# Goal
Your program must determine the possible exits of a maze.  
The maze can have several exits or none, and may contain loops or parts that cannot be reached from the starting point.

# INPUT
* Line 1: two ints W and H representing the width and height of the maze.
* Line 2: two ints X and Y representing your start position in the maze.
* H following lines: one row of the maze. A . represents an empty cell and a # represents a wall that cannot be traversed.

# OUTPUT
* Line 1: an integer N representing the number of exits.
* N following lines: two ints EX and EY representing the coordinates of each exit, given ordered by EX, then by EY (i.e. 2 10 comes before 5 1).

# CONSTRAINTS
* 7 <= W <= 21
* 7 <= H <= 21
