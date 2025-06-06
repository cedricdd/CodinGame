# Puzzle
**Dungeon 3D** https://www.codingame.com/training/medium/dungeon-3d

# Goal
Anya and her team of adventurers are battling in a multi-layered labyrinth beneath Waterdeep. Skeletons and Kobolds are lurking around every corner. Luckily Anya found the dungeon map which shows the structure of all layers of the dungeon including the location of a health-restoring Hot Spring.

Anya identified the team's current location on the map. She has to find the path to the Hot Spring to rebuild the team's health for prolonged battles.

All layers of the dungeon have the same rectangular dimension composed of cubic cells. The layers are connected by vertical ladders for climbing up or down.

The team takes 1 minute to fight their way to move from one cell to the adjacent cell, which is the cell at any of the four directions of their current cell as well as the cells at the vertically upper and lower layers, if there is a path to. They cannot move to diagonal cells directly.

What is the minimum time needed for the team to reach the Hot Spring?

# Input
* Line 1: Three integers L R C
* L is the number of levels making up the dungeon.
* R and C are the number of rows and columns making up the plan of each level.
* Line 2: ln calculated from L * (R+1), which is the total number of lines below it.
* The following ln lines: These are the floor plans of all levels, arranged in order from the surface layer to the deepest underground layer.
* Each level floor plan starts with a blank line and then R lines of characters.
* Each character describes one cell of the dungeon. An accessible cell, a passage, is represented by a dot. An inaccessible cell, a wall, is represented by '#'.
* The current location of Anya is indicated by 'A' and the Hot Spring by the letter 'S'.
* The boundary of the dungeon is hard rock, not drawn on the map.

# Output
* Line 1: Write an integer, the shortest time in minutes for the team to arrive at the Spring.
* In case it is impossible, write a line: NO PATH

# Constraints
* 1 ≤ L, R, C ≤ 30
* 2 ≤ L * R * C
