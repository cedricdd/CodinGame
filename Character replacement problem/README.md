# Puzzle
**Character replacement problem** https://www.codingame.com/training/easy/character-replacement-problem

# Goal
This program problem is to replace the characters in a multi-line string m of n lines of length n.  
A string s is an indication of the character to be replaced and the character after the replacement.  
For example, If ox xx indicated, In this case, o is replaced by x, and x is replaced by x (in some cases, the indication of change to the same character is given. in that case, ignore it).  
In answer, you should output the final figure of the string.  
The final figure of the string is the figure in which all letters have been replaced.  
For example, If ab bt tz indicated, the letter a in the figure must all be z in the final figure of the string.  
A set of substitutions is valid if the replacing process is well defined and eventually finishes. If the given set is not valid, output ERROR.  

In this case, x can replace i or k in a two patterns, which is inconsistent.  
Therefore, the output is ERROR as the answer.

# Input
* Line 1: A string s for the instructions for character replacement.
* Line 2: An integer n for the size of the string figure.
* Next n Lines: A multi-line string m.

# Output
* If the instructions are correct, output the final figure.
* If not, output ERROR.

# Constraints
* A string s is all lowercase alphabetical characters.
* 15 < s.length() < 30
* 3 <= n <= 5
