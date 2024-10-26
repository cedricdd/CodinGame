# Puzzle
**Pixel Polygons** https://www.codingame.com/contribute/view/10172135f180f2aa28d3304db783a5612211c2

# Goal
You have an NxN grid consisting of white and black square pixels. White pixels are represented by . and black pixels are represented by #. The pixels on the outer edges of the grid are all white.

The black pixels form a single connected polygon without any holes (no group of white pixels is completely surrounded by black pixels).

How many sides does it have?

To be clear, the black area is a single region composed of one or more unit squares, and thus, all of its angles are 90 or 270 degree angles.

# Input
* Line 1: An integer N - the size of the grid
* Next N lines: - the rows of the grid

# Output
* Line 1: The number of sides the black region has.

# Constraints
- 3 ≤ N ≤ 10
- The pixels on the outer edge of the grid are all white.
- The black pixels form a single connected region.
- No group of white pixels is completely surrounded by black pixels.
