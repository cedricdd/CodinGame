# Puzzle
**11-puzzle** https://www.codingame.com/training/hard/11-puzzle

# The Goal
This is a 3 by 4 sliding puzzle with one tile missing. The objective is to place the tiles in order by making sliding moves that use the empty space.
  
You are given the initial state of the board and you must output a list of moves to rearrange the tiles.

Each tile is numbered from 1 to 11 (0 is the empty space). The final state is the following:
```
0  1  2  3
4  5  6  7
8  9 10 11
```

In order to make a move, you need to print the coordinate of the tile you wish to move and it will take the place of the empty space.  
The coordinate of a tile is the couple (row, column), with (0, 0) the top-left element.

# Input
* 3 lines: 4 space separated integers that represent the initial state of the puzzle.

# Output
* For each move: two space separated integers that are the ROW and the COLUMN of the tile to move.

# Constraints
* Response time first turn ≤ 1000ms
