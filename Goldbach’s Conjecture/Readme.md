# Puzzle
**Goldbach’s Conjecture** https://www.codingame.com/training/medium/goldbachs-conjecture

# Goal
Goldbach's conjecture is one of the oldest and best-known unsolved problems in number theory and all of mathematics.   
It states that every even natural number greater than 2 is the sum of two prime numbers.  

For each given integer m, find when possible (all premises for the conjecture are true) , all distinct prime couples summing to m, and print their count.

When it's not possible print OOS (for OUT OF SCOPE).

Example explaination: 38 get these 2 possible sums
```
38 = 7 + 31
38 = 19 + 19
```

# Input
* Line 1 : An integer n, the number of numbers to compute
* n next lines : an integer m, the number for which the all the couples of prime factors must be found, counted and printed.

# Output
* n lines, each containing the count to each of the n given numbers

# Constraints
* 0 < n <= 120
* 0 <= m<=1 000 000
