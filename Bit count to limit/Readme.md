# Puzzle
**Bit count to limit** https://www.codingame.com/training/medium/bit-count-to-limit

# Goal
The goal is really simple. Given a number n, count how many 1s are used to write all binary integers from 0 to n (inclusive)

For example, n = 5
```
0....000...0
1....001...1
2....010...1
3....011...2
4....100...1
5....101...2
```
Total : 1+1+2+1+2 = 7

# Input
* Single line: An integer n

# Output
* Single line: Number of 1s used to write all binary integers from 0 to n (inclusive)

# Constraints
* n < 2^28
* Result < 2^32
