# Puzzle
**Detective Pikaptcha EP2** https://www.codingame.com/training/easy/detective-pikaptcha-ep2

# Goal

Thanks to your help, Detective Pikaptcha was able to get a sense of where he was trapped: a space-warp maze! Pikaptcha knows well that a space-warp maze has no visible exit; he must find his own way.

“Time to test a good old trick and see what happens: follow a wall and keep a count for each cell of how many times I stepped into it.”  
Your objective is to write a program that will compute, for each cell of a maze, the number of times Pikaptcha will step into the cell by following a wall until he reaches his original location.   

# Rules
The maze is given to you as a grid filled with 0s and #s, where 0 represents a passage, and # represents a wall: an impassable cell.  
The initial position and direction of Pikaptcha is given to you in the grid as a special character:
```
    >: facing right
    v: facing down
    <: facing left
    ^: facing up 
```
An additional character indicates which wall Pikaptcha must follow:
```
    R for the wall on his right
    L for the wall on his left 
```

We’re considering the 4-adjacency, meaning a cell has a maximum of 4 adjacent cells (a diagonal cell is not adjacent).  
You must analyze the given maze and return it with a small transformation: for each empty cell, instead of a 0, you must return the number of times Pikaptcha stepped into that cell while striding along the maze, following a wall. For each impassable cell, you change nothing: you still return #. 


# Input
* First line: 2 integers width and height for the size of the maze.
* Next height lines: a string line of length width where 0 is a passage and # is a wall and >, v, < or ^ is the initial position of Pikaptcha.
* Next line: a character side for which wall to follow (from Pikaptcha's perspective).
* The maze is enclosed in impassable rocks that are not included in the data.

# Output
* height line of width characters each containing the transformed grid.

# Constraints
* 1 ≤ width & height ≤ 100
* Allotted response time to output is ≤ 2s
