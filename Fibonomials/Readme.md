# Puzzle
**Fibonomials** https://www.codingame.com/training/medium/fibonomials

# Goal
Let's define "fibonomial sequence" as a sequence of polynomials (P0(x), P1(x)...Pi(x),...) such that:
* P2(x) = P1(P0(x)) + P0(P1(x))
* P3(x) = P2(P1(x)) + P1(P2(x))
* ...
* P{n+2}(x) = P{n+1}(Pn(x)) + Pn(P{n+1}(x)).

Given either the coefficients or the roots of the first two polynomials P0 and P1, output the fibonomials sequence of size n for a given integer x (i.e. P0(x), P1(x), P2(x), ..., P{n-1}(x)).  
If an element of the sequence is quite big, i.e. abs(Pi(x)) >= 10^12, format it in scientific notation with 6 decimal precision (7 significant figures, Cf. example 2 below).

The string entry defined_by takes one of the values COEFS, ROOTS to specify whether the polynomials are defined by their coefficients (increasing powers) or by their roots.  
COEFS ===> P0 = a0 + a1 x + a2 x^2 + ... + ai x^i + ...  
and likewise P1 = b0 + b1 x + b2 x^2 + ... + bi x^i + ...  
ROOTS ===> P0 = (x-a0) (x-a1) (x-a2) ... (x-ai) ...  
and likewise P1 = (x-b0) (x-b1) (x-b2) ... (x-bi) ...  

Example 1:  
```
defined_by = COEFS  
ai = -1 2 ==> P0 = 2x-1 ...(eq. 1)  
bi = 3 0 -1 ==> P1 = -x^2+3 ...(eq. 2)  
x = -5  
n = 3  
```

Solution:
```
(eq. 1 & 2) ==> P1(P0(x)) = -P0^2+3= -(2x-1)^2+3 ... (eq. 3)
(eq. 1 & 2) ==> P0(P1(x)) = 2*P1-1 = 2*(-x^2+3)-1 ... (eq. 4)
(eq. 3 & 4) ==> P2(x) = P1(P0(x))+P0(P1(x)) = -(2*x-1)^2+3 + 2*(-x^2+3)-1 ... (eq. 5)
Thus, for x = -5:
(eq. 1) ==> P0(-5) = 2*(-5)-1 = -11
(eq. 2) ==> P1(-5) = -(-5)^2+3 = -22
(eq. 5) ==> P2(-5) = -(2*(-5)-1)^2+3+2*(-(-5)^2+3)-1 = -163
```

Example 2:
```
defined_by = ROOTS
ai = 0 0 0 1 -1 ==> P0 = x^3 (x-1) (x+1) = x^5 - x^3 ...(eq. 1)
bi = 1000 ==> P1 = x-1000 ...(eq. 2)
x = -10
n = 3
```

Solution:
```
(eq. 1 & 2) ==> P1(P0(x)) = P0 - 1000 = x^5 - x^3 - 1000 ... (eq. 3)
(eq. 1 & 2) ==> P0(P1(x)) = P1^5 - P1^3 = (x-1000)^5 - (x-1000)^3 ... (eq. 4)
(eq. 3 & 4) ==> P2(x) = x^5 - x^3 - 1000 + (x-1000)^5 - (x-1000)^3 ... (eq. 5)
Thus, for x = -10:
(eq. 1) ==> P0(-10) = -10^5 - (-10)^3 = -99000
(eq. 2) ==> P1(-10) = -10 - 1000 = -1010
(eq. 5) ==> P2(-10) = -10^5 - (-10)^3 - 1000 + (-1010)^5 - (-1010)^3 = -1051009019899000 = -1.051009E+15
```

# Input
* Line 1: The string defined_by COEFS or ROOTS
* Line 2: Integers ai for all the coefficients or roots of the first polynomial P0, separated by a whitespace.
* Line 3: Integers bi for all the coefficients or roots of the second polynomial P1, separated by a whitespace.
* Line 4: An integer x for which the fibonomials are evaluated.
* Line 5: An integer n for the size of the sequence.

# Output
* n lines: The n integers elements of the fibonomial sequence, one per line. Output an element in scientific notation #.6#E+# if the element's absolute value is greater than or equal to 10^12.

# Constraints
* 1 <= n < 32
* -2^63 <= x < 2^63
