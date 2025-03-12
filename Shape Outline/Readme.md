# Puzzle
**Shape Outline** https://www.codingame.com/training/medium/shape-outline

# Goal
Given a shape in an H x W pixel grid, where # represents a part of the shape, and . represents an empty space, you need to output the outline of the shape as a sequence of vertices. Start from the top-leftmost point of first line of text and follow the shape's boundary in a clockwise direction. Multiply vertex X and Y with pixel size S to get the final coordinates.

The top-leftmost vertex of the grid is (0, 0), with the X-coordinate increasing towards the right and Y-coordinate increasing downwards. A single square represented in the input is made of S units of length.

Every shape can be drown with a single stroke. There are no hollow spaces or diagonally touching squares (forming the shape), only one path can be followed.

# Input
* Line 1: H height of the pixel art grid
* Line 2: W width of the pixel art grid
* Line 3: S pixel size
* Next H lines: pixel art line

# Output
* N lines: Two space-separated integers, representing the X and Y coordinates of a vertex of the shape's outline (and there are N vertices in total).

# Constraints
* 2 ≤ H ≤ 19
* 2 ≤ W ≤ 32
* 4 ≤ N ≤ 140
