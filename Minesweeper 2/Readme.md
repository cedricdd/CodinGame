# Puzzle
**Minesweeper 2** https://www.codingame.com/training/medium/minesweeper

# Goal
Find the hidden mines in the grid, knowing that:  
* \. means no danger in any of the 8 spaces around that spot.  
* n means there are exactly n mines hidden in the 8 spaces around that spot.  
* ? means we don't know anything about that spot.  

# Input
* Line 1 : The size of the grid, h : height & w : width .
* Line 2 : The number of hidden mines, nb.
* h following lines : Content of the grid made of ., ? and n.

# Output
* nb lines including mine's location : col & lin separated by a space.
* In column ascending order, then in line ascending order for the same column.

# Constraints
* 3 ≤ h, w ≤ 20
* 1 ≤ nb ≤ 20
