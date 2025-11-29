# Puzzle
**Suguru Solver** https://www.codingame.com/training/medium/suguru-solver

# Goal
Suguru (also known as Tectonics) is a puzzle game similar to Sudoku. The puzzle is made up of different zones, called cages.   
Each cage is 1 to 6 cells and contains the digits from 1 to the size of the cage. I.e., a 2-cell cage contains the digits 1 and 2, and a 5-cell cage contains the digits 1 to 5.   
Adjacent cells, even diagonally, may never contain the same digit.  

To help visualize what a Suguru puzzle looks like, here is the puzzle from the first test case with added walls around the cages (with and without the cage identifiers):
```
+--+--+--+--+  +--+--+--+--+
|G  G4 G1 G |  |    4  1   |
+--+  +--+--+  +--+  +--+--+
|R |G |B  B |  |  |  |     |
+--+--+--+  +  +--+--+--+  +
|G |R  R4|B |  |  |    4|  |
+  +  +  +  +  +  +  +  +  +
|G |R  R2|B |  |  |    2|  |
+  +--+  +  +  +  +--+  +  +
|G3 G |R |B |  | 3   |  |  |
+--+--+--+--+  +--+--+--+--+
```

# Input
* Line 1: The width and height separated by a space
* Next h lines: w space separated cells, where each cell is an upper case letter indicating the cage followed by a digit or a dot (indicating an empty cell)

The upper case letters used as cage indicators can be used for multiple cages as long as the cages do not touch each other horizontally or vertically.

# Output
* h lines: w digits corresponding to the solution for each cell of the line

# Constraints
* 4 ≤ w,h ≤ 20
* 1 ≤ cage size ≤ 6
* All tests have a unique solution
