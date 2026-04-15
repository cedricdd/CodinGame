# Puzzle
**The Hole Truth** https://www.codingame.com/training/medium/the-hole-truth

# Goal
You are given a 2D grid where # represents solid material and . represents empty space.

Empty space is connected using 4-connectivity (up, down, left, right; diagonals do not count).

A hole is a connected region of . that does not touch the border of the grid.

Your task is to count the number of holes in the grid.

# Input
* Line 1: Two space-separated integers W and H -- the width and height of the grid.
* Next H lines: A string of W characters, each either # or .

# Output
* Line 1: A single integer: the number of holes in the grid.

# Constraints
* 3 ≤ W, H ≤ 75
* There is at least one # cell.
* There is at least one . cell.
