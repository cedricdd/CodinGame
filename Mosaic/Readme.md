# Puzzle
**Mosaic** https://www.codingame.com/training/medium/mosaic

# Goal
You must solve the Mosaic puzzle, also known as Fill-In.

You are given a grid of squares, some of which contain numbers.   
Those numbers indicate how many of the immediately surrounding squares (including the cell with the number itself) are filled-in.   
Every square must be marked as filled-in or empty, and there is exactly one solution for each puzzle.  

Logic alone should be sufficient to solve the puzzle, but you can also explore possibilities and backtrack from contradictions.

Note: the grid does not wrap, so whereas inner cells have 9 surrounding cells, edge cells only have 6, and corner cells only have 4.

# Input
* Line 1: Integer N, representing the width and height of the grid.
* Next N lines: N characters representing the grid; each character is either a single-digit number or . otherwise.

# Output
* N lines of N length strings containing .'s to indicate empty cells and #'s to indicate filled cells.

# Constraints
* 3 ≤ N ≤ 25
