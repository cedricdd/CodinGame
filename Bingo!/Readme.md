# Puzzle
**Bingo!** https://www.codingame.com/training/medium/bingo/solution

# Goal
Provided with a set of bingo cards, and the order in which the numbers will be called, output how many numbers need to be called before somebody has a line, followed by how many numbers need to be called before somebody has "bingo" (all numbers on their sheet filled in).

A bingo card is defined as a 5x5 set of numbers between 1 and 90. The center of a bingo card is a "free space", meaning it is already filled in - this is denoted with a 0 in this puzzle.

A line on the bingo card is defined as any row, column or diagonal of 5 numbers on the card.

# Input
* Line 1: An integer n for the number of bingo cards in play
* Next n*5 lines: The numbers bn on the bingo cards, separated by spaces.
* Line n*5+2: The order in which the numbers cn will be called, separated by a space. You are provided all 90 numbers.

# Output
* Line 1: The amount of numbers that need to be called before a bingo card has a complete line.
* Line 2: The amount of numbers that need to be called before a bingo card has a full house (all numbers filled).

# Constraints
* 0 < n ≤ 10000
* 0 ≤ bn ≤ 90 ("free space" is signified with a 0)
* 0 < cn ≤ 90
