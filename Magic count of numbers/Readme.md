# Puzzle
**Magic count of numbers** https://www.codingame.com/training/hard/magic-count-of-numbers

# Goal
You should calculate a count of natural numbers not greater than n and divisible at least by one of k given primes.  
For example, you are given:
```
n = 25
k = 2
p = {2, 5}
The numbers are: 2, 4, 5, 6, 8, 10, 12, 14, 15, 16, 18, 20, 22, 24, 25.
The answer is 15.
```

# Input
* Line 1: An integer n and an integer k
* Line 2: k space separated primes p_i (1<=i<=k)

# Output
* A single line containing a one integer - count of numbers.

# Constraints
* 1 <= n <= 10**13
* 1 <= k <= 10
* 2 <= p_i < 40
