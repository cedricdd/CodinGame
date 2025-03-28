# Puzzle
**ASCII Art with Logo Language, Part 3** https://www.codingame.com/contribute/view/466124ac340257fe757f0c1e985d750cdfca1

# Goal
Your job is to extend again the Logo language developed in ASCII Art with Logo Language, part 2 with variables and giving the Turtle the ability to move in any direction.

*Commands from part one and two (not modified):*  
* SETPC pen: uses cyclically the characters in pen as Turtle pen.
* CS character: CLEARSCREEN. Clears the screen with the specified symbol (only printable ASCII excluding space).
* PU: PENUP. Sets the turtle to move without drawing.
* PD: PENDOWN. Turtle leaves a symbol when moving.

*Modified commands:*  
* RP expression [commands]: REPEAT. This instruction repeats the commands that are inside the square brackets the number of times indicated by the expression parameter (only positive integer). REPEAT command can be nested. If expression is negative or float, get the absolute value of its integer part.
* FD expression: FORWARD. Moves Turtle forward for number of times specified (absolute value of the integer part).
* RT expression: RIGHT. Turns Turtle right for number of degrees specified (only integer part). Negative numbers are possible (and they turn the Turtle to the left).
* LT expression: LEFT. Turns Turtle left for number of degrees specified (only integer part). Negative numbers turn the Turtle to the right.

*New commands:*  
* MK "varname expression: MAKE. Assign the expression's value to the variable varname.

For example:  
MK "dummyvar (12+3)-2

expression is a combination of numbers (integer and float with . as decimal separator) and the four operators + - / *, possibly with brackets ( ) to change the order of priority of calculation, and variables referenced by : followed by the variable name (no spaces).

For example:  
MK "dummyvar (12+3)-2;MK "dummy2 15*((12+3.5)-:dummyvar)

The value of :dummy2 is 37.5  
IF boolean expression [commands]: Conditional. The boolean expression is limited to expression = > < <> expression, where <> means "not equal to". If the boolean expression is true, the commands will be executed, else jump to the next command.

*Procedure definition:*  
All the procedures should be defined at the beginning of the program.  
STOP: exit from procedure.  
TO procedure_name :param END: procedure definition, with only one fixed parameter. Recursion is possible. To call a procedure simply put the procedure_name and an expression as parameter.  
It is not possible to use a parameter with the same name of a variable. Inside a procedure it is possible to use global variables but you can't change their value. The variables defined inside a procedure are locals. 

For example  
```
to spiral :size
   if :size > 30 [stop]
   fd :size; rt 15
   spiral :size *1.02
end
```

*Drawing lines:*  
Since the RT and LT commands now accept expressions, it is possible to draw lines with any integer inclination. You should implement the Bresenham's line algorithm, in particular the version that use Bresenham's principles of integer incremental error to perform all octant line draws, balancing the positive and negative error between the x and y coordinates. See the wikipedia link in reference to see all the details.

To draw a line, you will need to determine the target coordinates using the following formulas, where angle is the current Turtle inclination and steps the parameter of FD command:
```
x0,y0 = current Turtle position  
x1 = x0+round(steps*cos(angle))  
y1 = y0+round(steps*sin(angle))  
plotLine(x0,y0,x1,y1)  
```

Please note that the rounding to use is 'ROUND_HALF_EVEN' and the precision is set to 5 digits.  
Also note that the Turtle leaves a symbol in the starting position each time it moves with pen down, but not in the final position.  

*Additional notes:*  
Semi-colons ; are used to separate instructions in a line of instructions. It may also be optionally used at the end of a line of instructions. Command keyword or a procedure name and its arguments/parameters are always separated by one or more space characters.  
A variable name is always followed by ;, [, ], a newline, an end-of-line, or one or more space characters. Other than the above, all other space characters are optional.  
A command keyword may be used as a procedure name or a variable name.  
All turtle steps will be drawn using the current PU/PD and SETPC settings.  
As is part two, Turtle starts with an angle of 90 degree (heading North), with the pen down and the initial symbol set to #.  

*References:*  
Part 1 https://www.codingame.com/training/medium/ascii-art-with-logo-language  
Part 2 https://www.codingame.com/training/medium/ascii-art-with-logo-language-part-2  

Bresenham's line algorithm https://en.wikipedia.org/wiki/Bresenham%27s_line_algorithm in particular see note 2 Zingl, Alois

https://en.wikipedia.org/wiki/UCBLogo

# Input
* Line 1: An integer N, indicating the program's number of lines.
* Next N lines: lines of text with Logo instructions.

# Output
* The ASCII Art generated.

# Constraints
* 1 ≤ N ≤ 2000
