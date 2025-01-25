# Puzzle
**Nonogram inversor** https://www.codingame.com/training/hard/nonogram-inversor

# Goal
Nonograms are also know as Hanjie, Picross or Griddlers.  
To solve one, you are given the number of contiguous cells of the same color in rows and columns.  
Progressively you can see what the pixelized picture looks like.  

You can check for more information https://en.wikipedia.org/wiki/Nonogram.

In this version, we have only two colors, black and white.  
You will be given the length of all black groups.  
Your work is to describe the puzzle by the length of all white groups.  

```
Input:                                                                         Output:   
──────                     1                                                   ──────
4 4                        1 2 3 4                    2 2 1 0                  
1 1                       ┌─┬─┬─┬─┐                  ┌─┬─┬─┬─┐                 2
2                        4│■│■│■│■│                 0│ │ │ │ │                 2
3                         ├─┼─┼─┼─┤                  ├─┼─┼─┼─┤                 1
4                        3│ │■│■│■│                 1│■│ │ │ │                 0
4     ► Looks like ►      ├─┼─┼─┼─┤   ► Inversor ►   ├─┼─┼─┼─┤   ► Result ►    0
3                        2│ │ │■│■│                 2│■│■│ │ │                 1
2                         ├─┼─┼─┼─┤                  ├─┼─┼─┼─┤                 2
1 1                    1 1│■│ │ │■│                 2│ │■│■│ │                 2
                          └─┴─┴─┴─┘                  └─┴─┴─┴─┘                 
```

Note: All puzzles have one solution that can be deducted logically.

# Input
* Line 1: width height of the grid
* Next width lines: length of adjacent black cells in the columns from left to right
* Next height lines: length of adjacent black cells in the rows from top to bottom

# Output
* First width lines: length of adjacent white cells in the columns from left to right
* Last height lines: length of adjacent white cells in the rows from top to bottom

# Constraints
* 1 < width < 21
* 1 < height < 21
