# Puzzle
**Bailey–Borwein–Plouffe Pi** https://www.codingame.com/training/hard/baileyborweinplouffe-pi

# Goal
TL;DR Given N find the Nth hexadecimal place value of pi in decimal (i.e. a value in the range [0,16) ).

It was originally thought that finding the nth digit of pi is only possible by finding the previous n-1 digits. The contributions of Bailey, Borwein, and Plouffe in 1995 show that in hexadecimal, each hexadecimal digit can be found individually.

The formula: ```pi = sum k in [0, +inf) {1/16^k * (4/(8*k+1) - 2/(8*k+4) - 1/(8*k+5) - 1/(8*k+6))}```

shows that any hexadecimal place of pi can be found with just multiplication and addition/subtraction.

A more readable version of the formula and further info can be found here:

https://en.wikipedia.org/wiki/Bailey%E2%80%93Borwein%E2%80%93Plouffe_formula

Your task is to abstract this knowledge to solve for the given hexadecimal place of pi.

# Input
* Line 1: An integer N for the hexadecimal digit of pi to extract.

# Output
* Line 1: The Hexadecimal value (as an integer in decimal) of the N'th place of pi in base-16

# Constraints
* 1 ≤ N ≤ 100,000
