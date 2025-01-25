# Puzzle
**Obsolete Programming** https://www.codingame.com/training/hard/obsolete-programming

# Goal
How is your CSB ? Very bad, in fact, and you have been moved from the prestigious Bot Division to the awful Legacy Softwares Division where you must maintain obsolete and crappy code that runs 90% of your corporation's business.

Today you must write an interpreter for a strange and forgotten language, written in a narrow character set : only uppercase letters, digits, minus sign, space and newline.

Basically the language is based on RPN (Reverse Polish Notation) with the abilty to define new instructions.

Lines are split in instructions separated by space(s).

If the instruction is a number, simply put in on top of the stack.  
The operations (ADD, SUB, MUL, DIV, MOD) pop the last two numbers out of the stack and push the result back on top.  
For example after, 2 5 SUB 8, the stack is -3 8.  
DIV is the integer quotient and MOD the remainder of the division.  

There are also operators that act on the stack itself:
* POP removes the top number.
* DUP duplicates the top number.
* SWP swaps the two top numbers. 4 5 SWP 6 swaps 4 and 5 then pushes 6 on top, the stack is 5 4 6.
* ROT brings to the top the third number of the stack. If the stack is 1 2 3 4, ROT changes it in 1 3 4 2.
* OVR copies the second top number of the stack on the top. If the stack is 1 2 3 4, OVR changes it in 1 2 3 4 3.

* POS removes the top number, push 1 if this number is ≥ 0, otherwise push 0.
* NOT removes the top number, push 1 if this number is 0, otherwise push 0.
* OUT removes the top number and print it on the standard output, followed by a newline char.

To define a new instruction the syntax is :  
DEF name RPN instructions END

The instructions between DEF and END are not executed immediately but stored to be executed when name appears as instruction outside, after its definition.  
name must not be an already defined instruction or a number.  
Note that name can appears in its own definition (recursion is available).  

For example  
DEF SQ DUP MUL END defines the instruction SQ  
when 4 SQ appears, 4 is pushed on the stack, then DUP then MUL are executed.  

Inside a definition, conditionals are available:  

IF RPN instructions FI  
remove the top number, if this number is not zero, the instructions between IF and FI are executed, and continue with instructions after FI.   
If the number is zero, the execution continues after FI.  

IF RPN instructions 1 ELS RPN instructions 2 FI  
Remove the top number, if this number is not zero, the instructions between IF and ELS are executed, and continue with instructions after FI.   
If the number is zero, the instructions between ELS and FI are executed and continue execution after FI.  

The two conditional structures can be nested.

# Input
* Line 1: N : number of input lines of code
* N lines: Obsolete code

# Output
* Any number of lines: whatever the obsolet program outputs

# Constraints
* 1 ≤ N ≤ 100
* All the numbers are signed integer (minimum width : 30 bits).
* All tests are correct (ie don't use undefined instruction) and use MOD and DIV instructions only with positive arguments.
