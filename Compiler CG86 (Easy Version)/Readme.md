# Puzzle
**Compiler CG86 (Easy Version)** https://www.codingame.com/contribute/view/123501d1d1cb34651439257e0478bb64d6f2b4

# Goal
CG86 is a minimal arithmetic compiler targeting a fictional assembly language. It supports only addition and subtraction, using a single register cgx, initialized to zero.

To reduce the instruction count, repeated operations can be compressed using the REPEAT instruction.

Instruction Set:  
* ADD cgx X: Adds X to cgx
* SUB cgx X: Subtracts X from cgx
* REPEAT N: Repeats the next instruction N times
* EXIT: Terminates the program.

The REPEAT instruction applies only to consecutive identical operations.  
The REPEAT instruction must come before the instruction it repeats.  

Instructions must reflect the original sequence of computation and may only be optimized using the REPEAT instruction. Reordering for further optimization is not permitted.

One Exception: If a number is repeated and appears again later in the sequence, even if interrupted, it must still be counted as part of the same REPEAT, as long as the repeated instructions are identical and consecutive in the compiled output.

The program must end with an EXIT instruction.  

# Input
* A single line containing a space-separated arithmetic expression, alternating between integers and + or - operators.

# Output
* A sequence of CG86 instructions, with one instruction per line, following the specified order and optimization rules.

# Constraints
* The length of the input expression is less than 1024 characters.
* All numbers in the input expression are integers between 1 and 9 (inclusive).
* The expression is well-formed and contains at least two numbers and one operator.
