# Puzzle
**ASCII Art with Logo Language, Part 2** https://www.codingame.com/training/medium/ascii-art-with-logo-language-part-2

# Goal
Your job is to extend the Logo language developed in ASCII Art with Logo Language by giving the Turtle the ability to move diagonally and some new commands (to check your first implementation's resiliency to the never-ending dance of changing requirements).

*Commands from part one (not modified):*  
* CS character: CLEARSCREEN. Clears the screen with the specified symbol (only printable ASCII excluding space).
* FD times: FORWARD. Moves Turtle forward for number of times specified (only positive integer).
* PU: PENUP. Sets the Turtle to move without drawing.
* PD: PENDOWN. Turtle leaves a symbol when moving.

*Modified commands:*  
* SETPC pen: uses cyclically the characters in pen as Turtle pen, changing every Turtle's step (of length 1) with pen down. Default value for pen is #. ; [ ] can't be used in pen. The index for cycling characters resets each time you use SETPC.
* RT angle: RIGHT. Turns Turtle right for number of degrees specified (only positive multiples of 45).
* LT angle: LEFT. Turns Turtle left for number of degrees specified (only positive multiples of 45).

*New command:*  
* RP loop [commands]: REPEAT. This instruction repeats the commands that are inside the square brackets the number of times indicated by the loop parameter.

For example:

RP 2 [FD 2]

is equivalent to

FD 2;FD 2

REPEAT command can be nested. For example:

RP 2 [RP 2 [RT 90;FD 2]]

is equivalent to

RT 90;FD 2;RT 90;FD 2;RT 90;FD 2;RT 90;FD 2

setpc 12345;rt 90;fd 5

produces
12345

As in part one, Turtle starts heading North, with the pen down and the initial symbol set to #.

*Reference Part1:*  
https://www.codingame.com/training/medium/ascii-art-with-logo-language

# Input
* Line 1: An integer N, indicating the program's number of lines.
* Next N lines: lines of text with Logo instructions.

# Output
* The ASCII Art generated.

# Constraints
* 1 ≤ N ≤ 2000
* angle: a positive integer multiple of 45.
* loop: a positive integer from 1 to 100.
* pen: an ASCII string excluding spaces and ; [ ].
