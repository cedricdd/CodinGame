# Puzzle
**Sliding Maze Puzzle** https://www.codingame.com/training/hard/sliding-maze-puzzle

# Goal
You're trapped in a maze designed on a 9 x 9 grid.

You're given the initial position of the tile you stand on (the tileset is described later) and the map of the maze.  
The following symbols describe each cell of the grid: "." indicates that the cell is located in floor 0, "=" indicates that the cell is located in floor 1, "+" represents a stairset between floor 0 and floor 1, "#" represents a wall (which prevents you to move on both floors) and "~" represents water.

The grid is divided into nine 3 x 3 tiles as seen in this example:
```
### #.# #.#
==# #.# #..
#=# #+# ###

#=# ~~~ ###
#== ~~~ +..
### ~~~ ###

#.# ### ###
#.. === ..#
### ### #.#
```

All maze configurations use the same nine tiles placed differently and potentially rotated. It means that you won't be surprised by a new tile shape.

The tiles can slide on water, leaving always one empty tile over water cells in a typical sliding puzzle fashion.  
For example in the previous maze the tile of row 1 and column 0 can move right, and the maze tiles become:

```
### #.# #.#
==# #.# #..
#=# #+# ###

~~~ #=# ###
~~~ #== +..
~~~ ### ###

#.# ### ###
#.. === ..#
### ### #.#
```

You must exit the maze by completing a sequence of moves. At each step, You can chose to move either the player from one whole tile to another or to slide a whole tile.

You must respect the following conditions:
- the player can walk from a tile of one floor to a tile of the same floor but cannot jump from one floor to the other one,
- if the player uses a stairset, then the player must necessarily end up on the other floor,
- an exception to the previous rule is: if a stairset directly leads to another stairset, it cancels your floor change so you go back to the same floor,
- the player cannot walk on water,
- to slide a tile, the player must be on a tile of floor 0 (that's where the mechanisms are located),
- you cannot slide the tile where the player stands.

The exit is located on floor 1, to the left of the top left tile location. It means that the player must reach the top left tile location on a floor 1 tile with an opening on the left wall or a floor 0 tile with a stairset leading left. The player then exits the maze by moving left.

# Input
* Line 1: Two integers R and C for the starting row and column of the whole tile where the player stands.
* 9 next lines : A row of the grid.

# Output
* Line 1: One integer N for the minimal number of instructions required to escape the maze.
* N lines : The instructions to escape the maze: the letter "P" for player or "T" for tile, one blank space, and a symbol "v", "<", ">", or "^" to describe the move (meaning respectively down, left, right and up).
* Note that you don't have to specify which tile is moving. For example if you say "T >", the moving tile is necessarily the left neighbour of the empty tile.
* Important note: If several solutions of length N exist, display the one that, for the first move, moves in priority player over tiles, and that prioritize directions in the following order: "v", "<", ">", "^". If there are still tied solutions, use the second move as a tie breaker, if it's not enough use the third move and so on until only one solution remains.

# Constraints
* N ≤ 200
