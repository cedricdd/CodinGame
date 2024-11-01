# Puzzle
**Constrained Latin Squares** https://www.codingame.com/training/medium/constrained-latin-squares

# Goal
Count all solutions to a partially filled Latin square.

A Latin square of order n is a n x n array filled with n different symbols, each occurring exactly once in each row and exactly once in each column.   
In this puzzle, you are given a n x n grid filled with digits between 0 and n.   
This grid forms a partially filled Latin square where digits above 0 cannot be changed (they are constrained) and zeroes can take any value between 1 and n.   
Your goal is to find the number of Latin squares that are solutions to this grid.  

# Input
* Line 1 : an integer n, dimension of the square grid.
* n lines : a string row with n digits corresponding to that row. A "0" is used for an unconstrained cell.

# Output
* Line 1: The number of solutions to the puzzle.

# Constraints
* 3 <= n <= 9
