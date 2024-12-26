# Puzzle
**Mountain Map Convergence** https://www.codingame.com/training/easy/mountain-map-convergence

# Goal
"We don't make mistakes, just happy little accidents." - Bob Ross

While creating mountains in ASCII, you realized that taller mountains could start off from the smaller ones, so why not make some more mountains?


Rules:
- You will be given a list of the heights of mountain peaks along a row.
- The starting height is considered as 0.
- Each step of rise in altitude is represented by '/' and fall by '\'.
- Each peak consists of a rise and fall '/\' at the appropriate height.
- Once a peak has been drawn, proceed either up or down to the next peak. Do not return to 0 between peaks.
- After generating the mountains, end at height 0.
- You may need to draw below 0. Remember, mountains are made from a step lower than their peak. Example, for -1 :
```
\    /   
 \/\/
```
which demonstrates the tip of the mountain at -1 height, given that the starting and ending point are at height 0.

This is an extension of "Mountain Map": https://www.codingame.com/ide/puzzle/mountain-map

# Input
* Line 1: A single integer n representing the number of mountains
* Line 2: n, space-separated integers that represent the height of each mountain in sequential order

# Output
* An ASCII representation of the mountains where each rise in altitude is represented by '/' and fall by '\'.

# Constraints
* 0 < n < 15
* -15 < height <15
* Note: The height must always end at 0.
