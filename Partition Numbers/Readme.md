# Puzzle
**Partition Numbers** https://www.codingame.com/training/medium/partition-numbers

# Goal
You must determine the partition number for a given integer n. The partition number p(n) represents the number of different ways n can be expressed as a sum of positive integers, irrespective of the order of addends.

*Example:*  
The partition number for the number 5 is 7 because there are 7 ways to express the number 5:
```
5
4 + 1
3 + 2
3 + 1 + 1
2 + 2 + 1
2 + 1 + 1 + 1
1 + 1 + 1 + 1 + 1
```

# Input
* Line 1: An integer T representing the number of test cases.
* Next T lines: An integer n for which you need to find the partition number.

# Output
* T lines: For each test case, an integer representing the partition number p(n).

# Constraints
* 1 ≤ T ≤ 15
* 0 ≤ n ≤ 100
