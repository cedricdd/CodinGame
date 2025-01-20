# Puzzle
**Shikaku Skill Builder** https://www.codingame.com/contribute/view/10244722a13a0e3269ba38f7c562148ed31d32

# Goal
This puzzle is part of a multi-part Algorithm X tutorial and is meant to be done per the guidance in the following playground: https://www.codingame.com/playgrounds/156252

*Task:*  
Given a grid of numbers, find all rectangles that cover each positive number without covering other positive numbers. Each rectangle must have an area equal to the number it covers.

# Input
* Line 1: The width and height of the grid, space separated.
* Next h lines: w space-separated integers. (0s indicate blank cells)

# Output
* Navigating the grid from left to right and from top to bottom, for each positive number n, if there is at least one rectangle of area n which covers n without covering other positive numbers (we’ll call each a good rectangle), output the following:
* Line 1: Three space separated integers: row col n, where row and col are the location of n on the grid.
* Next 1 or more lines: Four space separated integers: r c width height for each good rectangle. r and c indicate the rectangle's top left corner. width and height indicate the rectangle's dimensions. These lines must be sorted by r, then c and then width.
* Note: For output purposes, rows and columns must be zero-indexed. The top-left corner of each grid is row 0, col 0.

# Constraints
* 2 ≤ w, h ≤ 30
