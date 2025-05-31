# Puzzle
**Takuzu Solver (Easy mode)** https://www.codingame.com/contribute/view/1201357bc6caad8a49cde8b385593250094a50

# Goal
Takuzu (aka 'Binary Sudoku' or 'Binairo') is a variant of Sudoku that only allows the numbers 0 and 1. The following three rules must be met for a valid solution:  
1. Each row and column must contain an equal number of 0s and 1s (e.g. 5 of each for a 10x10 grid).
2. No row or column may contain a sequence of three or more repeating digits (e.g. 1 1 0 is valid but 1 1 1 is invalid) (Hint: you can solve this 'Easy mode' puzzle with just this rule)
3. No rows (or columns) can be duplicates of other rows (or columns).

Given an integer n and an incomplete nxn binary grid of 0s and 1s, with . symbols for unknown values, complete the grid by replacing all the unknown values with 0s and 1s, obeying the required rules.

There will only be one valid solution.

Hard version: https://www.codingame.com/training/hard/takuzu-solver (Hint: you will need to include a backtracking algorithm)

# Input
* Line 1 : An integer n, the size of the grid (always even)
* Next n lines : A row of n characters: 0, 1 or . (for unknown values)

# Output
* n lines : The completed board, with all . replaced with valid 0s and 1s, following the rules.

# Constraints
* 4 < n < 16
* n is even
* All boards have a single valid solution
* All boards can be solved using rule 2 alone (easy mode).
