# Puzzle
**The Labyrinth of Numbers** https://www.codingame.com/contribute/view/1322790b5eb6f58ef6850982c41483144f8a0d

# Goal
You are trapped inside a mysterious square labyrinth of size n×n. The labyrinth is filled with the numbers from 1 to n^2 , arranged in a clockwise spiral starting at the top-left cell (position (1,1)).

Your task is to determine the number located at a given position (r,c) within this spiral.  
Note: A direct simulation will be too slow for large n. Find an efficient mathematical solution.  

# Input
* Line 1: 3 space-separated integers n, r and c:
* n — integer, the size of the square grid (n × n)
* r — integer, the row number of the target cell
* c — integer, the column number of the target cell

# Output
* The number at position (r, c) in the spiral.
  
# Constraints
* 1 ≤ n ≤ 100000
* 1 ≤ r, c ≤ n
