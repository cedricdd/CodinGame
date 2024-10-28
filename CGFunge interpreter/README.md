# Puzzle
**CGFunge interpreter** https://www.codingame.com/training/medium/cgfunge-interpreter

# Goal
CGFunge is a 2-dimensional, positional programming language.  
This means that execution of a CGFunge program follows a designated pattern on a grid of ASCII characters.  
Each command in the language is a single character. The most basic commands involve flow control:  
* '>' - Continue to the right
* '<' - Continue to the left
* '^' - Continue up
* 'v' - Continue down
* 'S' - Skip the next character and continue with the subsequent character
* 'E' - End the program immediately

Execution always starts on the first character of the first line and proceeds to the right. Spaces are ignored. 

The execution of the program entirely revolves around a stack consisting only of integers in the range [0 - 255].  
Any digit encountered (0 - 9) is pushed onto the stack. Arithmetic operators ('+', '-', '*')  
pop two operands from the stack and push the result onto the stack.  
For subtraction, the top element on the stack is subtracted from the second element on the stack. So, for example, the program "52 - E" would leave the value 3 on the stack.

The following commands perform other basic stack manipulation tasks:  
* 'P' - Pop the top value
* 'X' - Switch the order of the top two stack values
* 'D' - Push a duplicate of the top value onto the stack

The quotation mark character ('"') toggles "string mode". When in string mode, the ASCII codes for all characters encountered are pushed onto the stack.

The following commands perform stack-based logical flow control:  
* '_' - Pop the top value from the stack. If it is 0, continue to the right. Otherwise, go left.
* '|' - Pop the top value from the stack. If it is 0, continue down. Otherwise, go up.

Output is performed with the following commands:  
* 'I' - Pop the top integer from the stack and print it to stdout.
* 'C' - Pop the top integer from the stack and interpret it as an ASCII code, printing the corresponding character to stdout.

# Input
* Line 1: An integer N indicating the number of lines in the program
* Next N lines: One line per program input

# Output
* The output of the properly interpreted program

# Constraints
* 1 ≤ N ≤ 10
