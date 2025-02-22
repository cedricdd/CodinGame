# Puzzle 
**2.5D maze** https://www.codingame.com/training/medium/2-5d-maze

# Goal
Link has to find the length of the shortest way out a 2.5D maze, he must save Zelda.

**The grid contains the following symbols:** 
* "." floor
* "+" short wall (you can walk over)
* "|" vertical slope
* "-" horizontal slope
* "#" high wall (you can’t walk across neither under or over)
* "X" bridge (you can walk under and over)
* "O" tunnel (you can walk under but not over)

Here is what Link sees when ".+#OX" is coded in front of him:
```
  ██_
_██__
```

He needs to go from starty/startx to endy/endx.  
Link can walk on the floor, on the short walls, under and over the bridges,  
under the tunnels but he shall neither fall (he would break his legs) nor walk diagonally.  
The slopes give the right to go up and down to be able to walk on the short walls and bridges and back to the floor
(from top or bottom for the vertical one, and left or right for the horizontal one).

**Link can safely assume that:**  
* the start and the exit are on the floor,
* the exit is reachable,
* the slopes and bridges are correctly placed,
* the maze is not pathological (for example, Link can’t go outside).

# Input
* Line 1: The coordinates of the start starty and startx (0 on top-left corner, screen-style)
* Line 2: The coordinates of the exit endy and endx (0 on top-left corner, screen-style)
* Line 3: The size of the maze height and width
* Next h lines: The maze itself

# Output
* The length of the shortest path to the exit, including the exit, not the start.

# Constraints
* 1⩽h,w⩽16
