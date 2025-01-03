# Puzzle
**Detective Pikaptcha EP** https://www.codingame.com/training/medium/detective-pikaptcha-ep3

# Goal

It worked! Oh wait... Detective Pikaptcha is now trapped in a more advanced type of space-warp maze. It looks like a ring but twisted. It doesn’t take long for Pikaptcha to realize that the maze is actually a gigantic Möbius strip.

“Let’s try the same method...”  
Your objective is to write a program that will compute, for each cell of a maze, the number of times Pikaptcha will step into the cell by following a wall until he reaches his original location.

# Topology
Pikaptcha looked up his database which responded, "A Möbius strip is a surface with only one side and only one edge." But wait...Pikaptcha found that this one is not the standard Möbius because the edge is gone. It is a variant having one endless looping surface and no edge. Pikaptcha can cross the edge to go to the other side of the strip if it is not blocked by walls.

The Möbius strip maze is given to you as a grid filled with 0s and #s, where 0 represents a passage, and # represents a wall: an impassable cell.

Here are instructions to create a real-world representation of a Möbius maze:  
* Print the first half (along the x-axis) of the grid on a piece of paper.
* Flip the paper over vertically.
* Print the rest of the grid on the side now in front of you.
* Give the strip a half-twist and connect the two ends to create a loop. 
    
# Rules
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

# Input
* First line: 2 integers width and height for the size of the Möbius strip.
* Next height lines: a string line of length width where 0 is a passage and # is a wall and >, v, < or ^ is the initial position of Pikaptcha.
* Next line: a character side for which wall to follow (from Pikaptcha's perspective).

# Output
* height line of width characters each containing the transformed grid.

# Constraints
* 1 ≤ width & height ≤ 200
* Allotted response time to output is ≤ 2s
