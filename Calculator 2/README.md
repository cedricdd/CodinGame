# Puzzle
**Calculator 2** https://www.codingame.com/contribute/view/936695cb79e78f5b0f69babe171e3ccf0554f

# Goal
The goal of this puzzle is to evaluate expressions containing numbers, the four basic operations and parenthesis.

You'll feed back the value of the expression, of course, but also the order in which you processed the operations.

For example, the expression (1+2)*(3+4) is equal to 21.  
You first calculated the two additions and then the multiplication : the order of operations will be ++* .

To avoid imprecisions of calculations, all results will be integers, and so divisions will always be without reminder.

# Input
* Line 1 : the expression expr to evaluate

# Output
* Line 1 : an integer fo the result of the expression
* Line 2 : a string containing all operations in order of computation (without spaces).

# Constraints
* expr is always a valid expression and contains digits (0 to 9), +, -, *, /, ( and ) only.
* The length of the expression is limited to 100 characters.
