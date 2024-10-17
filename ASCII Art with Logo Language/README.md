# Puzzle
**ASCII Art with Logo Language** https://www.codingame.com/training/medium/ascii-art-with-logo-language

# Goal
Your job is to implement a simple Logo interpreter that draws ASCII Art with a Turtle.  
In this challenge you will implement only a limited subset of Logo instructions, and the Turtle will move only in horizontal or vertical lines.  
You should implement the following statements (case insensitive):  
* CS character: CLEARSCREEN. Clears the screen with the specified symbol (only printable ASCII excluding space).
* FD times: FORWARD. Moves Turtle forward for number of times specified (only positive integer).
* RT angle: RIGHT. Turns Turtle right for number of degrees specified (only positive multiples of 90).
* LT angle: LEFT. Turns turtle left for number of degrees specified (only positive multiples of 90).
* PU: PENUP. Sets the turtle to move without drawing.
* PD: PENDOWN. Turtle leaves a symbol when moving.
* SETPC character: Sets the symbol (only printable ASCII excluding space) that the Turtle will use. For example:

Multiple instructions on the same line are separated with semicolon ;. For example:  
PD;FD 10

Turtle starts heading North, with the pen down and the initial symbol set to #.  
The Turtle leaves a symbol in the starting position each time it moves with pen down, but not in the final position.  
For example:  
RT 90;PD;FD 1;PU;FD 1;PD;FD 1

Output: 
```
# #
```
All leading spaces should be removed only to the extent that the overall image is not affected. All unnecessary spaces at the end of the lines should be removed. For example:  

FD 2;RT 90;FD 3

Output (there are no spaces in row 1 and row 2 after #):  
```
###
#
#
```

Reference: https://en.wikipedia.org/wiki/MSWLogo

# Input
* Line 1: An integer N, indicating the program's number of lines.
* Next N lines: lines of text with Logo instructions.

# Output
* The ASCII Art generated.

# Constraints
* 1 ≤ N ≤ 2000
  
angle: a positive integer multiple of 90.
