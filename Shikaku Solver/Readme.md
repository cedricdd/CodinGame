# Puzzle
**Shikaku Solver** https://www.codingame.com/training/medium/shikaku-solver

# Goal
Find all solutions to a Shikaku puzzle.

Shikaku is a puzzle played on a rectangular grid. Some of the squares in the grid are numbered.   
The objective is to divide the grid into rectangular pieces such that each piece contains exactly one number, and that number represents the area of the rectangle.

If the puzzle is poorly designed, there might be more than one solution. The goal here is to find all the solutions to a given puzzle.

We will use the letters (A-Z,a-z) to represent the rectangles. Going left to right then top to bottom, you should encounter the rectangles (A-Z,a-z) in order.

https://en.wikipedia.org/wiki/Shikaku

# Input
* Line 1: The Width and Height of the puzzle, space separated.
* Next H lines: W space separated numbers to fill out the grid (0 for blank cells, otherwise the area value).

# Output
* Line 1: The number of solutions to the puzzle. There will always be at least one solution.
* Next H lines: W characters (A-Z,a-z) for each line of the solution. If there is more than one solution, 
* Return the solution that comes first if you concatenate all rows and sort lexicographically.

# Constraints
* 10 ≤ W,H ≤ 30
