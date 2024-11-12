# Puzzle
**Crossword** https://www.codingame.com/training/medium/crossword

# Goal
Given two horizontal words (H1, H2) and two vertical words (V1, V2), find out if they can be printed so that they all intersect two by two.

Each horizontal word must cross both vertical words.  
Each vertical word must cross both horizontal words.  

Words cannot be side by side:  
The two horizontal words must be at least one row apart from each other.  
The two vertical words must be at least one column apart from each other.  

If there is one and only one solution, print out the crossword grid with dots "." for empty spaces.  
Otherwise, print the number of solutions (could be zero). 

The grid shall be adjusted to its minimal size.  

# Input
* Line 1: A horizontal word H1
* Line 2: A horizontal word H2
* Line 3: A vertical word V1
* Line 4: A vertical word V2

# Output
* The crossword grid if there is one and only one solution.
* The number of solutions otherwise.

# Constraints
* 1 ≤ length of each word ≤ 12
