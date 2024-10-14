# Puzzle 
**1010(1)** https://www.codingame.com/training/medium/10101

# Goal
This is the first in a series of 1010 puzzles.

You are given a grid of width W and height H. Each cell is either empty, represented as a dot ".", or filled, represented with a hash "#".

You are allowed to place a 2x2 block in the grid wherever it will fit (i.e., all of those 2x2 cells are empty).

You must find a place for your 2x2 block to completely fill as many rows and columns and report how many rows and columns you can complete.

# Input
* Line 1: An integer W for the width of the game board.
* Line 2: An integer H for the height of the game board.
* Next H lines: A string of W characters, either . or #

# Output
* N: the maximum number of columns and rows that could be completed by placing a 2x2 block on the given grid, or 0 if there is no place for your 2x2 block. 
Placing the block means converting a 2x2 area of empty cells "." to filled "#"

# Constraints
* 3 ≤ W ≤ 10
* 3 ≤ H ≤ 10
* The grid will never already have any completed rows or columns.
