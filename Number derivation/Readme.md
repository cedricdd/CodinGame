# Puzzle
**Number derivation** https://www.codingame.com/training/easy/number-derivation

# Goal
You have to calculate the derived number of a given positive integer, following these rules:
* If a number is prime p, p′=1.
* If a number is the product n×m, (n×m)′=n′×m+n×m′.

Yes, it follows almost all the traditional rules of the derivation, including 1′=0 and (p^n)′=n×p^(n−1) if p is prime; but not (p+q)′=p′+q′ for all p and q.

# Input
* A number n.

# Output
* The derivation of n

# Constraints
* 1 < n ⩽ 10000
