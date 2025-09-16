# Puzzle
**Robot Reach** https://www.codingame.com/training/easy/robot-reach

# Goal
A robot starts at cell (0, 0) on a grid with R rows and C columns.  
The robot is able to move one cell at a time. It can only move left, right, up or down (no diagonals). Every cell in the grid has a value. The value of each cell is the sum of the digits of the row index plus the sum of the digits in the column index.   
Note, its the sum of the digits of these indices, not the index values. Eg, cell (3,4) has value 7 and cell (11, 35) has value 10 (1+1+3+5).

The robot has a threshold T. It can only visit cells whose value less or equal to this threshold. Eg, if the robot's threshold is 6, it cannot visit (3,4) whose value is 7.

Here's a sample table with R=5, C=5 and T= 2
```
   | 0  1  2  3  4
 ------------------   
 0 | 0  1  2  3  4
 1 | 1  2  3  4  5
 2 | 2  3  4  5  6
 3 | 3  4  5  6  7
 4 | 4  5  6  7  8
 ```

In the sample above the robot can visit exactly 6 cells, all the ones where the cell value is <= 2.

Given R=50, C=50, T=18, cell (35, 37) has row/col digit sum of 3+5+3+7=18.  
If the robot could get to (35,37) it could land on that cell since 18 is less or equal to the threshold 18. However, it cannot land on cell (35, 38) because 3+5+3+8=19 and that is greater than the threshold.

Your job is to compute how many cells can the robot reach if it starts at (0,0), can move up, down, left or right 1 cell at a time and wants to visit as much of the grid as possible.

# Input
* Line 1: integer R - the number of rows in the grid
* Line 2: integer C - the number of columns in the grid
* Line 3: integer T - the robot's threshold

# Output
* Line 1: Integer count of cells the robot can reach.

# Constraints
* 1 <= R <= 100
* 1 <= C <= 100
* 0 <= T <= 100
