# Puzzle
**Zergling rush** https://www.codingame.com/training/hard/zergling-rush

# Goal
In the popular real-time strategy game called Starcraft, there are three races: Terran, Protoss, and Zerg.   
Many Zerg players use a "cheese" strategy called the "zergling rush", where very early in the game, they produce a couple of their basic combat unit called the "zergling", and immediately attack the enemy base.  

The enemy base is represented as a grid, with buildings occupying different shapes. Additionally, there can be some impassable terrain blocking zerglings.  
Zerglings will surround all enemy buildings they can reach, taking up horizontally, vertically, and diagonally adjacent cells. However they cannot access locations completely blocked off by buildings or terrain.   
Note that they will only be able to enter horizontal or vertical gaps: if buildings are diagonally adjacent they will block the zerglings.  

Your task is to visualize what the base will look like after the zerglings arrive.  

Note 1: zerglings enter from all sides (top, left, right, bottom).  
Note 2: if no building can be reached or if there are no buildings at all, the zerglings will not stay (no zerglings should be included in the output).

For example, a base like:
```
...#####
...#...#
..B..B.#
...#...#
...#####
```

will become
```
...#####
.zz#...#
.zB..B.#
.zz#...#
...#####
```

Zerglings surround the building to the left, but cannot access the building to the right because their path is blocked.

# Input
* Line 1: Two integers, W and H corresponding to the width and the height of the grid.
* Next H lines: The enemy base in the following format:
  * \. = empty space
  * B = building
  * \# = impassable terrain

# Output
*   H lines: The enemy base after zerglings arrive. Zerglings are represented by z

# Constraints
* 0 < W, H < 20
