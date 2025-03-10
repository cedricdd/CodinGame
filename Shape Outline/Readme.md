# Puzzle
**Shape Outline** https://www.codingame.com/contribute/view/118023d04a8141bb6c38329d453898cd497c82

# Goal
Given a shape in an H x W pixel grid, where # represents a part of the shape, and . represents an empty space, you need to output the outline of the shape by starting from the top-left point of the shape and following the shape's boundary in a clockwise direction. Multiply vertex X and Y with pixel size S to get the final coordinates.

X-coordinates increase towards the right. Y-coordinates increase towards the bottom. The origin (0, 0) is at the top-left corner of the grid

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
