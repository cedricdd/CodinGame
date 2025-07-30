# Puzzle
**All Operations are Equal!** https://www.codingame.com/training/medium/all-operations-are-equal

# Goal
A positive integer X is a good number if there exist 5 (not necessarily distinct) positive integers A, B, C, D, and E such that:
* A + B + C + D = X
* A + E, B - E, C * E, and D / E are pairwise equal, meaning A + E = B - E = C * E = D / E

The smallest good number is the number 8. This is because there are five positive integers (A, B, C, D, E) = (1, 3, 2, 2, 1) such that:  
* 1 + 3 + 2 + 2 = 8
* 1 + 1 = 3 - 1 = 2 * 1 = 2 / 1 = 2

You are given N positive integers. For each number, determine whether the number is good or not!

# Input
* Line 1: An integer N for the number of positive integers given.
* Next N lines: An integer X for the positive integer in question.

# Output
* N lines: A word YES if the number is good, or NO otherwise.

# Constraints
* 1 ≤ N ≤ 100
* 1 ≤ X ≤ 100000
