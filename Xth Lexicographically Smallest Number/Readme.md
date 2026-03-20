# Puzzle
**Xth Lexicographically Smallest Number** https://www.codingame.com/contribute/view/107925de0c08195433c6f6bc0c759ff32a9f7b

# Goal
Given four integers m, n, b, and x:
- Consider all integers from m to n (inclusive).
- Sort these integers as if they were written in base-b, in lexicographical order.

Find the x-th integer in this order and return it in base-10.

Example:
```INPUT: 2 15 3 8```

Let's first translate the numbers from 2 to 15 into base 3:
```
2 => 2
3 => 10
4 => 11
5 => 12
6 => 20
7 => 21
8 => 22
9 => 100
10 => 101
11 => 102
12 => 110
13 => 111
14 => 112
15 => 120
```

Let's then sort them lexicographically:
```[10, 100, 101, 102, 11, 110, 111, 112, 12, 120, 2, 20, 21, 22]```

The 8th number (starting from 1) is 112, i.e. 14 in our decimal system.
```OUTPUT: 14```

# Input
* Line 1: Four integers m, n, b, and x, separated by spaces, where:
  * m: The smallest number in the range.
  * n: The largest number in the range.
  * b: The base in which to express the numbers.
  * x: The position as a 1-based index in the sequence.

# Output
* Line 1: The decimal number that corresponds to the xth number in the lexicographically sorted list of base-b representations.

# Constraints
* 0 < m ≤ n < 10 Billion
* 0 < x ≤ (n - m + 1)
* 2 ≤ b ≤ 36
