# Puzzle
**Fun with CGX Expressions** https://www.codingame.com/training/medium/fun-with-cgx-expressions

# Goal
You have to parse the CGX file format (see CGX Formatter https://www.codingame.com/training/hard/cgx-formatter for details) to evaluate an expression.  
The CGX file contains a BLOCK with 2 KEY_VALUE fields: result and vars.  
The result BLOCK contains the variable whose final value should be calculated and returned as output, while the vars BLOCK contains a list of the intermediate variables.  
Each variable (a KEY_VALUE) has a value that is an expression.  
An expression could be:  
- a constant value PRIMITIVE_TYPE int,
```
e.g. ('v1'=10)
```
- if the expression is a PRIMITIVE_TYPE str, then it is a variable name,
```
e.g. ('v1'='v2')
```
- a BLOCK with 3 KEY_VALUE num1 , num2 and an operator: + - / *,
```
e.g. ('num1'=expression;'num2'='v2';'operator'='+') 
```
is the value of the variable v2 plus the value of the expression.
The order ('num1';'num2';'operator') is not guaranteed, any arrangements are possible, ex: ('num1';'operator';'num2'), ...

- a fraction BLOCK in the form ('numerator'=expression;'denominator'=expression),
```
e.g. ('numerator'=1;'denominator'=2) is 1/2.
```

The computations must be carried out in exact fractional form, in the lowest terms. e.g. 5/9+7/9=4/3.

# Input
* Line 1: The number N of CGX lines.
* The N following lines: The CGX content.

# Output
* The result of the expression in the KEY_VALUE 'result'.

# Constraints
* 1 <= N <= 30
* -2^63<=numerator and denominator <=2^63
* The CGX content supplied will always be valid.
* Each line contains maximum 1000 characters.
* All the characters are ASCII.
* A KEY_VALUE 'result' will always be present.
* The 'result' is always a number (integer or fraction).
* The 'vars' BLOCK could be present if necessary.
* There are no circular references.
