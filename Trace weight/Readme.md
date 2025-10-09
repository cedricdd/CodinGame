# Puzzle
**Trace weight** https://www.codingame.com/contribute/view/704706fdeae4cf5f28272756647c9c7ce4ae7

# Goal
You are given an integer t for the number of tests. Each test is a space separated string containing three substrings: base, target, and fixed.

You want to know if you can go from base to target by swapping, any amount of times, adjacent letters that are not in the fixed string.

For each test, if you can go from base to target then print the minimum number of allowed swaps necessary. If you can't go from base to target print -1.

# Input
* Line 1 : An integer t, the number of tests.
* Next t lines: A space separated string test containing three substrings: base, target, and fixed.

# Output
* t lines, each containing the answer to the corresponding test.
* The answer can be either:
  - the minimum number of allowed swaps necessary to go from base to target.
  - -1 if no allowed transformation goes from base to target

# Constraints
* Every character of base, target and fixed is a lowercase letter of the alphabet.
* There are no duplicate characters in fixed
* Every character in fixed appears at least once in base and once in target
* 0 < length(test) < 256
