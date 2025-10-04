# Puzzle
**Unit Fractions** https://www.codingame.com/training/easy/unit-fractions

# Goal
For every fraction in the form 1/n (where n is an integer > 0), we can always find two positive integers x and y such that:
```
1/n = 1/x + 1/y
```

There can be one or more pairs of x and y fitting the above equation.

Example
```
Given n = 2
1/2 = 1/6 + 1/3
1/2 = 1/4 + 1/4
```

# Input
* Line 1: Integer n

# Output
* All combinations of n, x, y in the format 1/n = 1/x + 1/y, where x ≥ y
* Sort the list by x in descending order.
* Write each equation on its own line.

# Constraints
* 1 ≤ n ≤ 1000000
