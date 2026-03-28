# Puzzle
**Latin Squares** https://www.codingame.com/contribute/view/145116f8b112d683c346f46b416194cd9f792b

# Goal
Complete a 4x4 grid by filling each of the empty cells (marked with .) with one symbol so that the grid becomes a valid Latin square.

For this puzzle, a valid Latin square is a 4x4 grid of symbols for which:
1. The grid contains exactly 4 distinct symbols.
2. Each row and each column contains each of these 4 symbols exactly once.

Example of a valid Latin square:
```
1234
2341
3412
4123
```

# Input
* 4 lines: A string line of length 4 representing one row of the grid.
* Each character is either:
  * . for an empty cell, or
  * one of the symbols that should fill the grid.

# Output
* A single line containing the symbols that must replace the . cells, in reading order (top to bottom, left to right), separated by spaces.
* If no valid completion exists, or if the input grid does not contain exactly 4 distinct non-. characters, output Invalid.

# Constraints
* Whenever a valid solution exists, you may assume it is unique.
