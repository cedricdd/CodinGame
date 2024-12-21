# Puzzle
**Micro Assembly** https://www.codingame.com/training/medium/micro-assembly

# Goal
The task is to write an interpreter for a very simplistic assembly language and print the four register values after the instructions have been processed.

Explanations:  
a, b, c, d: registers containing integer values  
DEST: write the operation result to this register  
SRC: read operand value from this register  
IMM: immediate/integer value  
SRC|IMM means that the operand can be either a register or an immediate value.  

Command and operands are always separated by a blank.  
The program starts with the first instruction, iterates through all instructions and ends when the last instruction was processed.  
Only valid input is given and there are no endless loops or over-/underflows to be taken care of.  

List of defined assembly instructions:
```
MOV DEST SRC|IMM
copies register or immediate value to destination register
Example: MOV a 3 => a = 3
```
```
ADD DEST SRC|IMM SRC|IMM
add two register or immediate values and store the sum in destination register
Example: ADD b c d => b = c + d
```
```
SUB DEST SRC|IMM SRC|IMM
subtracts the third value from the second and stores the result in destination register
Example: SUB d d 2 => d = d - 2
```
```
JNE IMM SRC SRC|IMM
jumps to instruction number IMM (zero-based) if the other two values are not equal
Example: JNE 0 a 0 => continue execution at line 0 if a is not zero
```

Full example:
```
(line 0) MOV a 3      # a = 3
(line 1) ADD a a -1   # a = a + (-1)
(line 2) JNE 1 a 1    # jump to line 1 if a != 1
```

Program execution:
```
0: a = 3
1: a = a + (-1) = 3 + (-1) = 2
2: a != 1 -> jump to line 1
1: a = a + (-1) = 2 + (-1) = 1
2: a == 1 -> don't jump
```

Program finished, register a now contains value 1

# Input
* Line 1 contains the blank-separated values for the registers a, b, c, d
* Line 2 contains the number n of the following instruction lines
* n lines containing assembly instructions

# Output
* Line with the four blank-separated register values of a, b, c, d

# Constraints
* 0 < n < 16
* -2^15 ≤ a, b, c, d < 2^15
* Overflow and underflow behavior is unspecified (and not tested).
