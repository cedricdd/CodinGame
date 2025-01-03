# Puzzle
**Knights Jam** https://www.codingame.com/training/medium/knights-jam

# Goal
The knight is a chess piece that, when placed on the o-marked square, can move to any of the x-marked squares (as long as they are inside the board):
```
.x.x.
x...x
..o..
x...x
.x.x.
```

Eight knights, numbered from 1 to 8, have been placed on a 3×3 board, leaving one single square empty (.).  
They can neither attack each other, nor share the same square, nor leave the board: the only valid moves are jumps to the empty square.

Compute the minimum number of valid moves required to reach the following ordered configuration by any sequence of valid moves:
```
123
456
78.
```

Output -1 if it is not reachable.

Example detailed: Possible in 3 moves
```
128       12.       123       123
356  -->  356  -->  .56  -->  456
7.4       784       784       78.
```

# Input
* Three lines of three characters (containing each of the characters 1-8 and . exactly once).

# Output
* One single integer corresponding to the smallest number of moves needed to reach the ordered configuration.
* -1 if it is not reachable.
