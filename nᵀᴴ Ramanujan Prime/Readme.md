# Puzzle
**nᵀᴴ Ramanujan Prime** https://www.codingame.com/training/hard/n-ramanujan-prime

# Goal
The nᵀᴴ Ramanujan prime is the smallest positive integer Rₙ such that there are at least n prime numbers in the range (x/2, x] for all x ≥ Rₙ.

The first few Ramanujan primes are:
```
2, 11, 17, 29, 41, 47, 59, 67, 71, 97, ...
```

Your task is to find Rₙ for a given n.

It is known that, for all n ≥ 1, Rₙ must lie within the range:
```
2n⋅ln(2n) < Rₙ < 4n⋅ln(4n)
```

# Input
* A single positive integer n.

# Output
* A single positive integer Rₙ.

# Constraints
* 1 ≤ n ≤ 10⁵
