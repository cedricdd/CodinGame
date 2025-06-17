# Puzzle
**teleporters and jumps** https://www.codingame.com/training/medium/maze-w-teleporters-and-jumps

# Goal
Your goal is to find the minimum amount of steps from start to end in a maze with teleporters and jumps and return -1 if it's not possible to reach the end.

You will be given a maze with width x height cells with symbols:  
- \#: wall
- _: empty cell
- S: starting point
- E: ending point
- lowercase letter: teleporter entry
- UPPERCASE letter: teleporter exit
- <, >, ^, v: jump pod

How teleporters work: x -> X meaning when you step on the x you will be teleported to X.   
This does not mean when you walk over the X that you will be teleported to x.  
How jump pods work: when you step on it, you jump 2 steps in the direction of the sign.  
You also jump over walls, but there won't be any out of bounds jump pods.   
Example: stepping on the > will make you jump 2 steps to the right, < to the left, ^ up, and v down. Letter v will not be used as a teleporter.  

Allowed moves are Up, Down, Left and Right, no diagonal moves.  

# Input
- Line 1: width of the maze
- Line 2: height of the maze
- Next height lines: string describing a row in the maze

# Output
- Single line containing the minimum amount of steps from start to end.

# Constraints
- 5 ≤ width ≤ 20
- 5 ≤ height ≤ 20
