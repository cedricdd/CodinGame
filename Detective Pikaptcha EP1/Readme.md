# Puzzle
**Detective Pikaptcha EP1** https://www.codingame.com/training/easy/detective-pikaptcha-ep1

# Goal

Detective Pikaptcha is investigating a disturbance in the spacetime continuum. It seems a powerful pokébot is being used to warp space around our hero to keep him trapped. Help him map his surroundings in order to escape and uncover the culprit!  
Your objective is to write a program that will compute, for each cell of a grid, the number of adjacent passages.
  
# Rules
You're given a grid filled with 0 and #, where 0 represents a passage, and # represents a wall: an impassable cell.

We're considering the 4-adjacency, meaning a cell has a maximum of 4 adjacent cells (a diagonal cell is not adjacent).  
You must analyze the given grid and return it with a small transformation: for each empty cell, instead of a 0, you must return the number of its adjacent passable cells. For each impassable cell, you change nothing: you still return #.

# Input
* First line: 2 integers width and height for the size of the grid.
* Next height lines: a string line of length width where 0 is a passage and # is a wall.
* The maze is enclosed in impassable rocks that are not included in the data.

# Output
* height line of width characters each containing the transformed grid.

# Constraints
* 1 ≤ width & height ≤ 100
* Allotted response time to output is = 2s
