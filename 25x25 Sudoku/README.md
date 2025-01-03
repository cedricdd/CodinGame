# Puzzle
**25x25 Sudoku** https://www.codingame.com/training/expert/25x25-sudoku

# Goal
You have to solve a 25x25 sudoku grid!

An empty cell is represented by . and the letters A to Y are used to fill the grid.

**RULES:**  
* Each line contains exactly one occurrence of each letter.
* Each column contains exactly one occurrence of each letter.
* Each block (5x5 cells) contains exactly one occurrence of each letter.

NOTE: This puzzle is considerably more difficult than a classic sudoku puzzle like https://www.codingame.com/training/medium/sudoku-solver.  
Simple backtracking will not be enough, knowing that there can be more than 300 unrevealed cells.

# Input
* Line 1 to Line 25 : 25 characters in the range A..Y or . (empty cell)

# Output
* Line 1 to Line 25 : 25 characters in the range A..Y

# Constraints
* Every grid has a unique solution.
