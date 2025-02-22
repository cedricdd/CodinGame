# Puzzle
**Length of Syracuse Conjecture Sequence** https://www.codingame.com/training/medium/length-of-syracuse-conjecture-sequence

# Goal
The Syracuse Conjecture concerns a sequence of integers defined as follows:
- start with any positive integer n. 
- Then each term is obtained from the previous term as follows: 
   * if the previous term is even
        the next term is one half the previous term. 
   * If the previous term is odd
        the next term is 3 times the previous term plus 1.


The conjecture is that no matter what value of n, the sequence will always reach 1.
https://en.wikipedia.org/wiki/Collatz_conjecture

For example, given the input 22, the following sequence is constructed: 22 11 34 17 52 26 13 40 20 10 5 16 8 4 2 1

Given an input n, it is possible to determine the number of terms in the sequence, including the terminating 1.  
For a given n, this is called the cycle-length of n.

In the example above, the cycle-length of 22 is 16.

For any two numbers A and B you are to determine the maximum cycle-length over all numbers between them.

# Input
* Line 1: An Integer N the number of ranges to compute.
* N next lines: Two integers A and B respectively the lower and upper bound of the range.

# Output
* N lines: i cycle_length the lowest integer that leads to the longest cycle-length, and the cycle length itself.

# Constraints
* 1 ≤ N ≤ 10
* 1 ≤ A ≤ i ≤ B ≤ 100000
* You can assume that no operation overflows a 32-bit integer
