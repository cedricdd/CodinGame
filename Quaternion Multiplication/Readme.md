# Puzzle
**Quaternion Multiplication** https://www.codingame.com/training/medium/quaternion-multiplication

# Goal
The quaternions belong to a number system that extends the complex numbers.   
A quaternion is defined by the sum of scalar multiples of the constants i,j,k and 1.  
More information is available at http://mathworld.wolfram.com/Quaternion.html  

Consider the following properties:
```
jk = i
ki = j
ij = k
i² = j² = k² = -1
```

These properties also imply that:
```
kj = -i
ik = -j
ji = -k
```

The order of multiplication is important.

Your program must output the result of the product of a number of bracketed simplified quaternions.

Pay attention to the formatting.  
The coefficient is appended to the left of the constant.  
If a coefficient is 1 or -1, don't include the 1 symbol.   
If a coefficient or scalar term is 0, don't include it.  
The terms must be displayed in order: ai + bj + ck + d.  

Example Multiplication
```
(2i+2j)(j+1) = (2ij+2i+2j² +2j) = (2k+2i-2+2j) = (2i+2j+2k-2)
```

# Input
* Line 1: The expression expr to evaluate. This will always be the product of simplified bracketed expressions.

# Output
* A single line containing the simplified result of the product expression. No brackets are required.

# Constraints
* All coefficients in any part of evaluation will be less than 10^9
* The input contains no more than 10 simplified bracketed expressions
