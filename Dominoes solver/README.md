# Puzzle
**Dominoes solver** https://www.codingame.com/training/hard/dominoes-solver

# Goal
Dominoes have been placed on a grid.  
All the dominoes with values between 0 and n appear exactly once, where n is given in the inputs.

We must find the disposition of these dominoes, given that all the problems have a unique solution.

Example:  
If n = 2, they are 6 dominoes: 0-0, 0-1, 0-2, 1-1, 1-2 and 2-2.

With this grid:
```
0021
1120
0212
```

there is only one position for dominoes 0-0, 1-1 and 2-2 (0-0 and 1-1 horizontal, 2-2 vertical)
```
==|1
==|0
0212
```

Then, we can find dominoes 0-1, 0-2 and 1-2(0-2 and 1-2 horizontal, 0-1 vertical) which leads to the final solution:
```
==||
==||
====
```

# Input
* Line 1: highest value n on the dominoes
* Line 2: height h and width w of the grid.
* h following lines: the content of the grid of domino's values.

# Output
* h lines: with only | or=
* | for a vertical domino
*  = for a horizontal domino

# Constraints
* 1 <= n <= 6
* 2 <= h, w <= 8
