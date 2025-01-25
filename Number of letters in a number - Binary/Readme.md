# Puzzle
**Number of letters in a number - Binary** https://www.codingame.com/training/medium/number-of-letters-in-a-number---binary

# Goal
Find the nth term in the sequence starting with S(0) = start and defined by the rule:

Given a term in the sequence, S(i), the next term, S(i+1) can be found by counting the letters (ignoring whitespace) in the spelled-out binary representation of S(i).

As an example, starting from 5 (S(0) = 5), we convert to the binary representation, 101, then spell it out as an English string "one zero one", and count the letters which yields 10 (S(1) = 10).

# Input
* Line 1: integers start and n, separated by a space

# Output
* Line 1: the nth term in the sequence, expressed as an integer

# Constraints
* 1 ≤ n ≤ 10^18
* 1 ≤ start ≤ 10^18
