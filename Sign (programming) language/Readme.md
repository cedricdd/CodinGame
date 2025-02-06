# Puzzle
**Sign (programming) language** https://www.codingame.com/contribute/view/117693c816369725266babb4979c3c82660478

# Goal
You are given an ordered collection of signs to interpret as an assembly language, which you need to execute to obtain a number.

The language assumes a simple integer register of unlimited size, although results will never go beyond 16-bit signed number capacity in practice. This register is set to 0, and operations apply to it to obtain a final value.

Instructions are executed from left to right, ignoring operator precedence. For example, /$$*?//// corresponds to ADD 3 followed by SUB 0, meaning the final result of the program is 0 + 3 - 0 = 3.

Available instructions are the following:

* ADD N (/$, N characters, /)
Add N to the register, e.g. /$+-^/ is "ADD 3".

* SUB N (//, N characters, /)
Substract N from the register, e.g. //+^+-$/ is "SUB 5".

* MUL N + 1 (/**, N characters, /)
Multiply N + 1 and the register, e.g. /****/ is "MUL 3" (2 + 1).

* MUL -N (/*/, N characters, /)
Multiply -N and the register, e.g. /*/**/ is "MUL -2".

* ADD INST COUNT ($)
This instruction can have two meanings:

  * If not counting, start counting the number of instructions from 0.
  * Otherwise, add the number of counted instructions to the register and stop counting.

Note that the $ instruction itself is not counted.

For example, $/$$$$///./$ to add 3, substract 1 then add 2 (number of instructions: ADD 3, SUB 1).

* NOP (/*$)
Do nothing.

All of the provided programs will be valid.

# Input
* First line: program to execute.

# Output
* First line: Result.

# Constraints
* 0 < length(program) < 512
-32768 <= any register value <= 32767
