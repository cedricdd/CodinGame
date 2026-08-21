# Puzzle
**Puzzle Squares** https://www.codingame.com/training/medium/squares

# Goal
Several potentially overlapping squares are drawn along the grid lines of a bounded square grid, partitioning it into distinct regions.

Each square is defined by a triple [ x, y, s ], where (x, y) represents the coordinates of its top-left tile and s denotes its side length.

Given a list of target tiles, calculate the area of the region containing each target tile.

For example:

On a 100 x 100 grid, two squares are drawn: [3, 2, 4] and [2, 4, 3].  
Tile A (3, 4): Region area = 4  
Tile B (5, 3): Region area = 12  
Tile C (1, 1): Region area = 9979  
```
    0   1   2   3   4   5   6 .....100
      ┌───+───+───+───+───+───+───+───┬───► x
    1 │ C ¦   ¦   ¦   ¦   ¦   ¦   ¦   │
      ┤- - - -┌───────────────┐- - - -│
    2 │   ¦   │   ¦   ¦   ¦   │   ¦   │
      ┤- - - -│- - - - - - - -│- - - -│
    3 │   ¦   │   ¦   ¦ B ¦   │   ¦   │
      ┤- -┌───┼───────┐- - - -│- - - -│
    4 │   │   │ A ¦   │   ¦   │   ¦   │
      ┤- -│- -│- - - -│- - - -│- - - -│
    5 │   │   │   ¦   │   ¦   │   ¦   │
      ┤- -│- -└───────┼───────┘- - - -│
    6 │   │   ¦   ¦   │   ¦   ¦   ¦   │
    : ┤- -└───────────┘- - - - - - - -│
    : │   ¦   ¦   ¦   ¦   ¦   ¦   ¦   │
    : ┤- - - - - - - - - - - - - - - -│
  100 │   ¦   ¦   ¦   ¦   ¦   ¦   ¦   │
      ├───────────────────────────────┘
      │
      ▼
      y
```

# Input
* Line 1: Three space-separated integers side M N.
  * side: Side length of the square grid.
  * M: Number of drawn squares.
  * N: Number of target tiles.
* Next M lines: Each line has three space-separated integers x y s defining a square with top-left tile (x, y) and side length s.
* Next N lines: Each line has two space-separated integers x y defining the coordinates of a target tile.

# Output
* Print N lines, each containing the area of the region for the corresponding target tile in the order given.

# Constraints
* 1 ≤ side ≤ 20000
* 1 ≤ M ≤ 4
* 1 ≤ N ≤ 100
* 1 ≤ x, y, s ≤ side
* None of the squares extend beyond the grid boundaries.
