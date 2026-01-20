# Puzzle
**Mystery sums** https://www.codingame.com/training/hard/mystery-sums

# Goal
You are given an expression comprised of integers separated by operators, as well as the result of the expression preceded by an equals symbol =.  
However, some of the digits in the expression have been replaced by question marks ?.  
You must restore the missing digits to the expression in such a way that it stays correct.  

The digits to the right of the equals sign = will never be replaced by question marks ? .  

Each expression can have several operators, but of the same type only.

# Input
* A single line expression containing positive integers, and the operators +, -, *, / and the = sign. Some digits will be replaced by ? characters. Each number and symbol is separated by a space.

# Output
* The same expression with each ? replaced with the proper digit for the expression to be true.

# Constraints
*expression contains less than 256 characters.
