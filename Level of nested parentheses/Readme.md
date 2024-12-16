# Puzzle
**Level of nested parentheses** https://www.codingame.com/training/medium/level-of-nested-parentheses

# Goal
Output for each pair of matching parentheses their level of nesting in an ASCII art graphic style.

The input is a string f of size n, with nested parentheses. Outermost parentheses have level-1, and each time a new pair of parentheses is nested into a previous one, its level is incremented by one, up to level-L.

The output is the same line, followed by an ASCII graphic: for each pair of parentheses, under each parenthesis there must be an arrow pointing up (^ and then | on the following line).  
These arrows should be longer if they contain nested parentheses: in this case, additional | are added to the next line to make them longer.  
Under these two arrows, there must be written the level of nesting (from 1 to 9) and those two numbers are linked by a horizontal line made of repeated -.  

Simple example:
```
(simple)
^      ^
|      |
1------1
```

Note that if a level-1 pair of parentheses does not contain any other parenthesis it will be displayed on the 4th line, as in this example. But, if in the same formula, in addition to this simple case, there is another pair of parentheses of level-1 containing a nested pair of parentheses of level-2 then this new level-1 will be shown on the 5th line (whereas the nested level-2 will occupy the 4th line). See test case 3 ("Two levels, unbalanced") for an example of level-1 statements being on two different lines.  

# Input
* f a string containing a formula with parentheses

# Output
* Line 1 : f the unchanged input formula
* L+2 next lines: a formatted ASCII string showing the level of nesting of each pair of parentheses (L being the maximum level of nested parentheses). All output lines must have the same size n (n being the size of the input string f): complete with spaces when necessary.

# Constraints
* The opening and closing parentheses in the input formula f are consistent
* 0 ≤ L ≤ 9
* 1 ≤ n ≤ 100
