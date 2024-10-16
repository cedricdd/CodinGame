# Puzzle
**16x16 Sudoku** https://www.codingame.com/training/medium/16x16-sudoku

# Goal
Backtracking is the process of incrementally exploring a problem space to find a solution, abandoning paths as soon as it can be determined they cannot lead to a solution. 
The term “brute force backtracking” is often used to describe a backtracking process that tries every possible path until a solution is found.

In some problems, the search space is so vast that brute force is impratical and a “smart” version of backtracking is needed. 
As the backtracking explores paths, some kind of logic is used to determine which remaining paths are still viable and which options to explore first to reduce the search tree.

For instance, in the classic Sudoku puzzle, the backtracking algorithm might know that a cell must be one of three values. 
A basic algorithm will try each of these values looking for a path to a solution and then try each remaining path from there. 
A smart algorithm will try each of the three values in the most promising order, and then reevaluate the remaining viable paths before moving forward. 
With such an approach, significant time can be saved.

**In this puzzle you have to solve a 16x16 sudoku grid!**  
However, the grids have been carefully chosen so that they cannot be solved within the time limit by brute-force backtracking. Proper solutions will need to add some “smartness” to the backtracking.

**RULES:** 
* An empty cell is represented by . and the letters A to P are used to fill the grid.
* Each line contains exactly one occurrence of each letter.
* Each column contains exactly one occurrence of each letter.
* Each block (4x4 cells) contains exactly one occurrence of each letter.

NOTE: These grids are challenging, but they are not advanced level grids. They can all be solved without Algorithm X or Dancing Links (DLX) which are often utilized for very difficult sudoku grids.

# Input
* Line 1 to Line 16 : 16 characters in the range A..P or . (empty cell)

# Output
* Line 1 to Line 16 : 16 characters in the range A..P

# Constraints
* Every grid has a unique solution.
