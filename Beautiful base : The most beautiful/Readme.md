# Puzzle
**Beautiful base : The most beautiful** https://www.codingame.com/training/hard/beautiful-base-is-a-beautiful-sum

# Goal
Let n be a positive integer. A "beautiful base" of n is any integer b > 1 such that log_⁡b(n) is an integer > 1, where log_b(n) denotes the logarithm of n in base b.

Determine the number of integers less than or equal to n that have at least one beautiful base and compute the sum of the sums of the beautiful bases of each of these integers.

For instance, there are 4 integers which are less than or equal to 16 that have at least one beautiful base:
- 4, admitting only 2 for beautiful base
- 8, admitting only 2 for beautiful base
- 9, admitting only 3 for beautiful base
- 16, admitting 2 and 4 for beautiful bases

The sum of the sums of the beautiful bases of each of these integers is 2 + 2 + 3 + (2 + 4) = 13, so your program should output "4 13".  

# Input
* An integer n.

# Output
* A single line containing the number of integers less than or equal to n that have at least one beautiful base, followed by a space, followed by the sum of the sums of the beautiful bases of each of these integers.

# Constraints
* 4 <= n <= 10^13
