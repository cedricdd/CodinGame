# Puzzle
**Shadow Casting** https://www.codingame.com/training/easy/shadow-casting/discuss

# Goal
Given an ASCII art pattern, cast a shadow as if the light source is at top-left corner to make the pattern 3D-like.  
Use hyphen (-) for darker shadow, and backtick (`) for lighter one.  
Darker shadow is projected by shifting existing pattern 1 character down and 1 character right.  
Lighter shadow is projected by shifting existing pattern 2 character down and 2 character right.  

# Input
* Line 1: An integer N for the number of lines of the ASCII art pattern.
* Next N lines: Lines of the ASCII art pattern.

# Output
* The processed pattern, with whitespace at the right trimmed, if any.

# Constraints
* 1 ≤ N ≤ 50
