# Puzzle
**Entanglement - Episode 1** https://www.codingame.com/contribute/view/136404d6e6cbe95afa0786008c7e521e38bca3

# Goal
Your task is to implement a scoring calculator for a game called Entanglement. According to the given rules, your program must determine how many points the player earns and which path they follow.

# Rules
The game is played on a hexagonal grid. The player places one hexagonal tile at a time. Each tile has 12 entrances numbered 0–11, forming 6 distinct path segments — each entrance connects exactly once. It follows that one path segment is represented by 2 integers entranceA and entranceB.

Note: Path segment entrances are unordered. This means path segment (3-7) is the same as (7-3).  
Example of a single tile with numbered entrances.

<img width="500" height="500" alt="7c34165a9a4d696305b071ab5b89bf9e1222cd96e989b098a5aeeeeaeaf0d232" src="https://github.com/user-attachments/assets/a58e6370-3f3e-40eb-b672-18f2f327835e" />


Gameplay:
* The game starts on the base tile at position [0, 0], at entrance 7.
* Each turn, the player places a new tile on the empty cell directly ahead (first move: [0, -1]).
* After placing a tile, the player follows the connected path.
* The path continues until it reaches an empty cell, the board edge, or returns to the base tile.
* The game ends once the path reaches the board edge or the base tile.

Scoring:  
Each move consists of placing one tile and following the resulting path. For every segment of the path passed through during this move, the player scores 1, 2, 3, ... points respectively. For example, if a path passes through 5 segments, the player earns 15 points in total. Your first task is to compute total score after each tile placement.

Coordinate System:  
The board has a fixed size, with all cells located at most 3 units away from the center. Your task is to print placement of all visited path segments, so make sure you understand the coordinate system used:

![d2fef08c29531d4f2a8a5b73cfa02aa2e96fbbfd719cb6ecfb76dad937fb356e](https://github.com/user-attachments/assets/9593e826-b21b-4c40-b2bb-dd8aa1ba2bd2)

# Input
* Each turn, you receive information about the tile placed on the board:
* 6 lines: 2 space-separated integers entranceA and entranceB that form a path segment of the tile.
  
# Output
* Line 1: The current total score.
* Line 2: Space-separated quadruples x y entranceA entranceB representing all visited path segments in correct order.

# Constraints
* Response time for the first turn: ≤ 1s
* Response time for subsequent turns: ≤ 50ms
