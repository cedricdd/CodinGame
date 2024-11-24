# Puzzle
**Factorials of primes decomposition** https://www.codingame.com/training/hard/factorials-of-primes-decomposition

# Goal
You have to decompose a positive integer/fraction as a product of powers of factorials of prime numbers.

For example:  
```
22 = (11!)^1 × (7!)^(−1) × (5!)^(−1) × (3!)^(−1) × (2!)^1  
10/9 = (5!)^1 × (3!)^(−3) × (2!)^1  
```

Use this special notation: prime number#power  
to denote each term, e.g. (11!)^4 is denoted as 11#4.

Output the non-zero terms only, with space separation, and order them in descending order of the prime numbers.

The above examples hence become:  
```
22 = 11#1 7#-1 5#-1 3#-1 2#1  
10/9 = 5#1 3#-3 2#1  
```

# Input
* Line 1: a positive number N, that can be either an integer or a fraction of the form numerator/denominator.

# Output
* Line 1: The ordered list of the non-zero terms of the decomposition of N, denoted using the special notation.

# Constraints
* 0 < N, numerator, denominator < 20000
* Every prime involved is less than 2000
