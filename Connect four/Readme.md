# Puzzle
**Connect four** https://www.codingame.com/training/hard/connect-four

# Goal
The classic game of Connect Four is played by two players in a grid of 6 rows by 7 columns, standing vertically.  
Players alternately drop one token from the top of one column, and the token falls to the lowest possible grid cell, stacking up on the tokens below it.  
The first player to make a horizontal, vertical or diagonal line of 4 tokens wins the game. 

From the description of one game grid, your program must determine in which columns each player may complete a line if they play first on the next turn.

# Input
* 6 lines: the game grid, given from top to bottom.
* 1 and 2 stand for the respective player's token and . for an empty cell.

# Output
* Line 1: the columns that would make player 1 win, sorted and separated by spaces, or NONE if there are no columns to output.
* Line 2: the columns that would make player 2 win, sorted and separated by spaces, or NONE if there are no columns to output.
* Column indices start at 0 for the left column.

# Constraints
* There is always at least one playable column (i.e. the grid is never full).
