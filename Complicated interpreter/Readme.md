# Puzzle
**Complicated interpreter** https://www.codingame.com/training/medium/complicated-interpreter/discuss

# Goal
Your task is to create an interpreter for a language that has 12 instructions (excluding comments).  
At the end, you have to output all the variable values separated by a space.

This language doesn't care about syntax, so for an example: "x = 2 n function x add 1" is legal, you could define a function and a variable in the same line, and this applies for everything else.

When defining functions/if statements/loops, you need to know that all the code that goes after it in the same line is its body.   
There's nothing that indicates their body end other than the end of the line.

When referencing variables, a dollar sign should be at the start, so: $x would represent the value of variable x, and x add $y would mean add y to x, when passing variables to an instruction that'll modify the given variable, you need to give the variable itself but not it's value. Variables that aren't valid should return an error, and in that case, print ERROR and stop the execution.

Comments are represented by a //, comments can be anywhere in the line, everything in the line after the comment should be ignored, while the rest before it executed.

Cases of errors: Invalid variables and invalid functions.  
Ex: Referencing variable x which does not exist, or calling function x which also does not exist.  
In case of an error: print ERROR and stop the execution.

Variables are ordered by the order at which they were first created, so the following example would output 5 1:  
```
x = 5
y = 3
z = 1
delete y
print
```

*Instructions*  

Format: Instruction || Description || Usage
```
print || Stop execution and print the variables || print
= || Assigning variables, variables will always be integers || identifier = value
add || Add value to variable || variable add value
sub || Subtract value from variable || variable sub value
mult || Multiply variable by value || variable mult value
delete || Delete variable from memory || delete variable
loop || Executes body for x amount of times || loop x do body
function || Create function name, everything after it is the function body, for this puzzle, 
this will not take arguments, nor return a value, but do changes || name function body
```

*Logical instructions*  

Everything here is only used in if blocks.
```
if || If the condition given is true, execute the body, otherwise skip it || if condition then body
== || Equality operator, If x is equal to y then it returns true|| value == value
!= || Not equal operator, if x is not equal to y then it returns true || value != value
or || Logical or operator, If at least one of the conditions are true it returns true || cond1 or cond2
and || Logical and operator, If both of the conditions are true it returns true || cond1 and cond2
```
Logical instructions accept literal integers or variable values, so variables are referenced when given.

A function call is a function call if it ends with (), functions and variables can have the same name. All names consist of letters only.

# Input
* Line 1: An integer n for the number of lines
* Next n lines: A string consisting of one or more instructions

# Output
* Line 1: All variable values separated by a space

# Constraints
* 2 <= n <= 8
