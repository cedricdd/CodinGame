# Puzzle
**Killer Sudoku Extreme Challenge** https://www.codingame.com/training/hard/killer-sudoku-extreme-challenge

# Goal
This puzzle builds on the concepts explored in the Killer Sudoku Solver puzzle by @odaxav. Please consider solving that puzzle before solving this one.

https://www.codingame.com/training/medium/killer-sudoku-solver

In this challenge, the goal is to generate a 9x9 grid of integers by solving Killer Sudoku puzzles.  
Your 9x9 answer grid is initially filled with zeros. Each time you solve a Killer Sudoku puzzle, add the number found in each Killer Sudoku cell to the the same cell in the answer grid.  
After solving every Killer Sudoku puzzle, output the 9x9 matrix of integers found in your answer grid.  

As the number of puzzles increases, speed and efficiency become critical.  
All Killer Sudoku puzzles in this challenge begin with empty grids. None of the puzzles have any numbers identified to start.  
The only input you have to work with is the cage layout and the cage values.  

Here are the 4 rules of Killer Sudoku:
1. Each row must have numbers from 1 to 9 with no repetition
2. Each column must have numbers from 1 to 9 with no repetition
3. Each region (3x3 square) must have numbers from 1 to 9 with no repetition
4. Each cage's cell numbers must sum to the cage value, with no repetition among numbers

The cages are represented in a 9x9 grid with an identifier from a-zA-Z.  
For this challenge, each puzzle's cages have been compressed into a single line by concatenating the rows of the 9x9 cage layout grid.  
The starting number grids have been omitted from this challenge since they are all empty.  

# Input
* Line 1: An integer numPuzzles for the number of Killer Sudoku puzzles to be solved.
* Next numPuzzles lines: cageID for each of the 81 cells in the corresponding Killer Sudoku puzzle. 
* Each character of the input line is mapped to the Killer Sudoku puzzle from left to right and then top to bottom.
* Next numPuzzles lines: The list of the cages with the sum of the cells cageID=cageSum

Note: Cage layouts and cage sums correspond to each other in the same order they appear in the input.

# Output
* 9 lines: Sums of all solutions to the Killer Sudoku puzzles. (separated by spaces)

# Constraints
* Each Killer Sudoku puzzle in each test case has only one solution.
