# Puzzle
**Continued Fractions** https://www.codingame.com/ide/puzzle/continued-fractions

# Goal
A continued fraction is a particular way of representing any standard fraction as an expanded out complex fraction with unit numerators.
```
p/q = x0+1/(x1+1/(x2+1/(x3+...+1/xn))...)
```
Where each xi is a positive integer (except potentially x0 which is just an integer and xn which is greater than 1). For compactness, this is represented as
```
p/q = [x0; x1, x2, ..., xn].
```
For example:
```
[2; 3, 2, 4] = 2 + 1/(3+1/(2+1/4))
= 2 + 1/(3+1/(9/4))
= 2 + 1/(3+(4/9))
= 2 + 1/(31/9)
= 2 + (9/31)
= 71/31
```
Similarly:
```
[-2; 1, 1, 3] = -10/7
```

If supplied a standard fraction, you must find the continued fraction representation or if supplied a continued fraction representation, you must find the standard fraction (in lowest terms) it represents.

Every rational number has a unique, terminating (finite) continued fraction as described and each continued fraction represents a unique standard fraction.

# Input
* String fraction either of the form "p/q" or of the form "[x0; x1, x2, ..., xn]"

# Output
* If you are given a standard fraction "p/q", you must return a string with the continued fraction representation in the form "[x0; x1, x2, ..., xn] where x0 is an integer and each other xi is a positive integer and xn > 1.
* If you are given a continued fraction, you must return a string with the standard fraction that it represents (as an improper fraction in lowest terms: p/q). If the fraction is negative, return it with the negative out front. ex: "-2/3"

# Constraints
* -1000 ≤ x0 ≤ 1000
* 0 < xi ≤ 1,000 for 0 < i < n
* 1 < xn ≤ 1,000
* -1,000,000 ≤ p ≤ 1,000,000
* 0 < q ≤ 1,000,000
