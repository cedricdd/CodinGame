# Puzzle
**Euclid's algorithm with complex numbers** https://www.codingame.com/training/easy/euclids-algorithm-with-complex-numbers

# Goal
This puzzle assumes that you have solved: https://www.codingame.com/training/easy/euclids-algorithm, or simply that you know how the GCD works for integers.

None of the math is explained nor needed. For those interested the references are at the bottom.

You will have to implement an analog of the euclidian division for Gaussian integers (complex numbers of the form x + iy with x and y integers). The pseudocode:

You are given two Gaussian integers a and b:  
1) Compute a/b = x + iy.
2) Find the closest integer cx to x and cy to y. *
3) The quotient q is then cx + icy.
4) The rest r is just a - q * b.

You can now compute the GCD of a and b. Print the steps in the suitable format. **

* If there are two possible choices pick the highest one. That is, if x = 0.5, pick 1. If x = -1.5, pick -1 etc.
* This puzzle follows the Python conventions for printing complex numbers. The tests are more telling than a detailed explanation.

Reference: https://www.cut-the-knot.org/arithmetic/int_domain4.shtml

# Input
* Line 1: A space separated string containing two integers, the first representing the real part xa and the second the imaginary part ya of a Gaussian integer a.
* Line 2: A space separated string containing two integers, the first representing the real part xb and the second the imaginary part yb of a Gaussian integer b.

# Output
* The steps of the GCD computation of a and b in the suitable format. This puzzle follows the Python conventions for printing complex numbers.

# Constraints
* xa, ya, xb and yb are all between -10000 and 10000 included.
