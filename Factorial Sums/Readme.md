# Puzzle
**Factorial Sums** https://www.codingame.com/contribute/view/136107ec9e4752ee2c3b006ca2d7e46cbc65ea

# Goal
A factorial number is one that is multiplied by all integers from the value n to 1.

Example:  
n = 5  
5x4x3x2x1 = 120

You have to find the smallest number of factorials whose sum equals a given number n.

Example:  
n = 10

10 can be expressed in several ways using factorials, for example:  
* 1! + 1! + 1! + 1! + 1! + 1! + 1! + 1! + 1! + 1!
* 3! + 1! + 1! + 1! + 1!
* 3! + 2! + 2!

Since the third expression above uses the fewest factorials among all possible combinations, the correct output is 3! + 2! + 2!.

Note: Since 0! = 1! = 1, always use 1! instead of 0! in the output.

# Input
* An integer n

# Output
* The required factorial sum expression of n. The factorials must be written in descending order (from largest to smallest). A term and a plus operator (+) must be separated by a space.

# Constraints
* 1 ≤ n ≤ 10000
