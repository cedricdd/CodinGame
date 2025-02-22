# Puzzle
**Pirate's treasure** https://www.codingame.com/training/easy/pirates-treasure

# Goal
The goal of this puzzle is to find a pirate's treasure. The pirate surrounded his treasure by obstacles.

# Input
* Line 1: Width W of the treasure map.
* Line 2: Height H of the treasure map.
* Next H lines: W symbols (0 or 1) indicating free space (0) or obstacle (1).

Treasure is placed on free space surrounded by only obstacles.

There are three possible ways in which the treasure can be surrounded:
* By 3 obstacles when the treasure is in the corner of the map.
* By 5 obstacles when the treasure is on the edge of the map.
* By 8 obstacles when the treasure is inside the map.

# Output
* The coordinates of the treasure on the map are represented by indices separated by a space. For example: "12 5"
* Position "0 0" is in the top left corner, so the maximum index x is W-1 and the maximum index y is H-1.

# Constraints
* 2 <= W <= 25
* 2 <= H <= 25
* Only 1 treasure in map.
