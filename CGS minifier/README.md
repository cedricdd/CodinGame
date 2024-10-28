# Puzzle
**CGS minifier** https://www.codingame.com/training/medium/cgs-minifier

# Goal
Your program must output a minified version of a CodinGame script formatted as CGS.

To do so, except for names between apostrophes ('), remove spaces, tabulations and display the code on one line.  
In addition, variables written between two ($) must be minified, the first variable of the script will be $a$, the second one $b$, etc.

# Input
* Line 1: The number N of CGS lines to be minified.
* The N following lines: The CGS content.

# Output
* Line 1: The minified CGS content.

# Constraints
* 0 < N < 10
* 0 ≤ number of variables in CGS content < 10
