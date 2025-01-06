# Puzzle
**Equation Search** https://www.codingame.com/contribute/view/100071e2989e321b98a5118cdacdf90ebf6d26

# Goal
This puzzle is a BONUS exercise associated with a multi-part Algorithm X tutorial and is meant to be done per the guidance in the following playground:

https://www.codingame.com/playgrounds/156252

Although you may use any language you wish to complete this puzzle, the playground is written for the Python programmer. Most importantly, the reusable Algorithm X Solver provided in the playground is written in Python. If you follow the directions in the playground and use Python, this puzzle should be significantly easier than if you choose another language or algorithm.

Task Overview:

You have to make n equations.

The left side of each equation contains 2 operands, chosen from 1 to 9. Each operand must occur a number of times as given in operandOccurrenceCounts, a list containing 9 space-separated integers. The first integer indicates how many 1s must appear as operands, the second integer indicates how many 2s must appear as operands, etc.

Operands on the left side of each equation must be in ascending order from left to right and must have either a + or a x (i.e. *) operator between them. There is no limitation on how many times each operator can be used in total. The right side of each equation contains a single integer, chosen from the given rightSides list. Each integer in rightSides must be used once.

If solutionCount = 1, you must print the equations in ascending order of the right side of the equation. All components of the equation (operands, operators, equal sign, constants) must be space separated.

Credit: This puzzle has been inspired by a puzzle found in an adventure game called “Mystery Detective Adventure” made by Five-BN Games.

#Input
* Line 1: An integer n, the number of equations in a solution.
* Line 2: rightSides - n unique, space-separated integers to be used on the right sides of the solution equations.
* Line 3: operandOccurrenceCounts - 9 space-separated integers indicating how many times each number from 1 to 9 must occur as an operand.

# Output
* Line 1: solutionCount - the number of unique solutions to the given input.  
  If solutionCount = 1, output: 
* Next n Lines: The equations that make up the solution, sorted per the instructions above.

# Constraints
* 2 <= n <= 15.
* 4 <= each value in rightSides <= 28.
* 0 <= each value in operandOccurrenceCounts <= 6.
