# Puzzle
**Detective Pikaptcha EP** https://www.codingame.com/training/hard/detective-pikaptcha-ep4

# Goal

As the expression goes, bad things come in threes. Detective Pikaptcha was not expecting to reach a third level of space-warping before being able to escape. This maze looks like it's being bent around the surface of a cube.

“Again, the wall-following method should work.”  
Your objective is to write a program that will compute, for each cell of a maze, the number of times Pikaptcha will step into the cell by following a wall until he reaches his original location. 

# Rules
The cube is given to you, one face after the other as 6 grids filled with 0s and # s, where 0 represents a passage, and # represents a wall: an impassable cell.  
The cube can be modelized as a paper box template with 6 faces as shown below:   
https://www.codingame.com/servlet/mfileservlet?id=31428821177278  

The faces are given in that order and orientation.  
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

We’re considering the 4-adjacency, meaning a cell has a maximum of 4 adjacent cells (a diagonal cell is not adjacent). Two cells touching the same part of the edge between two faces of the cube are considered adjacent.

Pikaptcha can step over the edge of a face and continue his wall-following path on another face of the cube. For Pikaptcha to be able to step over the edge, the two cells touching that part of the edge should be passable.  
You must analyze the given maze and return it with a small transformation: for each empty cell, instead of a 0, you must return the number of times Pikaptcha stepped into that cell while striding along the maze, following a wall. For each impassable cell, you change nothing: you still return #. 


# Input
* First line: 1 integer N for the size of the N*N*N cube.
* Next 6*N lines: a string line of length N where 0 is a passage and # is a wall and >, v, < or ^ is the initial position of Pikaptcha.
* Next line: a character side for which wall to follow (from Pikaptcha's perspective).

# Output
* 6*N lines of N characters each containing the transformed grid, in the same order as the faces were given in.

# Constraints
* 1 ≤ N ≤ 100
* Allotted response time to output is ≤ 2s
