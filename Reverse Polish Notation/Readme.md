# Puzzle
**Reverse Polish Notation** https://www.codingame.com/training/medium/reverse-polish-notation

# Goal
You have to correctly interpret RPN (Reverse Polish Notation) instructions and print the stack when the instruction line has been read (from left to right).  
If the instruction is a number, simply put in on top of the stack (on the right).  
The operations (ADD, SUB, MUL, DIV, MOD) pop the last two numbers out of the stack and push back on top the result.   
You can safely assume that the numbers are all integers.  
For example after, 2 5 SUB 8, the stack is -3 8.  

DIV is the integer quotient and MOD the remainder of the division.  
There are also operators that act on the stack itself:  
* ```POP``` removes the top number.
* ```DUP``` duplicates the top number.
* ```SWP``` swaps the two top numbers. 4 5 SWP 6 swaps 4 and 5 then pushes 6 on top, the stack is 5 4 6.
* ```ROL``` pops the top number then brings to the top the nth number of the stack starting from the right where nth is top number we popped.
  
For example, if the stack is ```1 2 3 4 3 ROL``` changes it in ```1 3 4 2```, 3 is popped and then the third number from the right moved at the end of the stack

# Input
* The first line is the number of instructions on the second line.
* The last line is the instructions line.

# Output
* You must print the stack, the top on the right.
* If an instruction has fewer operands than needed or if we try to divide by 0, stop everything and print ERROR after the current stack. The popped values before the crash are still popped. For example if the stack is ```1 2 3 0``` and we try ```MOD```, the stack will be ```1 2``` and you have to print ```1 2 ERROR```.

# Constraints
* 0 < N < 100
