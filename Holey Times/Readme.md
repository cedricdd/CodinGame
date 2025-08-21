# Puzzle
**Holey Times** https://www.codingame.com/training/medium/holey-times

# Goal
You have to fill in all the unknown digits in a multiplication.  
These unknown digits are marked as stars * in the operation.  
Note that the numbers involved never begin with a zero, excepted when a line is null.  
* For example, 234 is possible everywhere.
* 00 is accepted but only as a full line in a partial result.
* 0234 is not possible, neither as operand, partial result or result.

The multiplication symbol is an x.  
The stars may appear everywhere in the operation:
* In the operands, in the partial results or in the result.
* In only one of the three, in two or three of them.

In the partial results, the first line has got no trailing zeroes (but might end by zero if you multiply 5×48). The second line has got one trailing zero, the second line has got two trailing zeroes, and so on. Why?  
Because if you calculate 907×757, in fact, the operation is shown as 907×(7+50+700)=907×7 [first line] + 907×50 [second line] + 907×700 [third line]. Thus, the operation must be shown as:
```
   907
x  757
------
  6349 → 7×907
 45350 → 50×907
634900 → 700×907
------
686599
```

And not as:
```
   907
x  757
------
  6350 → 50×907
 45349 → 7×907
634900 → 700×907
------
686599
```

# Input
* Line 1: The number n of lines of the operation
* Next n lines: The holey multiplication

# Output
* Write the input but with the stars replaced with digits.
* No star shall be left.

# Constraints
* There is only one solution.
