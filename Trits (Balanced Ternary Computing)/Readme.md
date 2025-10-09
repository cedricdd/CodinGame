# Puuzle
**Trits (Balanced Ternary Computing)** https://www.codingame.com/training/medium/trits-balanced-ternary-computing

# Goal
Although ternary computing has fallen out of favor these last 40 years or more, there is reason to think that it may be an important part of the future.  
Whereas each digit in a binary system has two possible states, ternary digits have three possible states. In the Balanced Ternary system, each digit represents either -1, 0, or +1.

In binary, each digit is worth its face value (1 or 0) multiplied by a power of two determined by its position:
```
Binary
┌──────> 1 * (2^3) = 8
│┌─────> 1 * (2^2) = 4
││┌────> 0 * (2^1) = 0
│││┌───> 1 * (2^0) = 1
1101               = 13
```

In Balanced Ternary, the system is similar except each value (-1, 0, or +1) is multiplied by a power of 3 determined by its position.   
"1" and "0" represent themselves and "T" represents -1 (it sort of looks like "-1", right?):  
```
Balanced Ternary
┌───────> +1 * (3^4) = 81
│┌──────> -1 * (3^3) = -27
││┌─────>  0 * (3^2) = 0
│││┌────> +1 * (3^1) = 3
││││┌───> -1 * (3^0) = -1
1T01T                = 56
```

In order to be able to use Balanced Ternary, we need to be able to do some rudimentary operations.  
You must develop an application that can evaluate expressions using five binary operators: left shift, right shift, addition, subtraction, and multiplication.  
The shift operators do not wrap. Some examples:  

Examples
```
1T0 >> 1 = 1T
1T0 >> 1T = 1
1T0 << 1 = 1T00
1T0 + 1 = 1T1
1T1 + 1 = 10T
1T0 - 1 = 1TT
1T * 1T = 11
```

Note: You may want to complete the easier related puzzle first: https://www.codingame.com/training/easy/balanced-ternary-computer-encode

# Input
* Line 1: The first operand, lhs.
* Line 2: The operator, op.
* Line 3: The second operand, rhs.

# Output
* A single line containing the evaluation of the input expression in Balanced Ternary, ret.

# Constraints
In Decimal:
* -3280 <= lhs <= 3280
* -3280 <= rhs <= 3280
* -3280 <= ret <= 3280

In Balanced Ternary:
* TTTTTTTT <= lhs <= 11111111
* TTTTTTTT <= rhs <= 11111111
* TTTTTTTT <= ret <= 11111111

op is one of +, -, >> , << , *.
