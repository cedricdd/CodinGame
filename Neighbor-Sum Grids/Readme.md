# Puzzle
**Neighbor-Sum Grids** https://www.codingame.com/training/hard/neighbor-sum-grids

# Goal
A (2-)neighbor-sum grid is a 5×5 matrix containing each number from 1 to 25 exactly once and where each value that is at least 3 can be obtained as the sum of two distinct values among its direct neighbors (horizontally, vertically and diagonally, so that an inner cell has 8 neighbors, a border cell has 5 neighbors and a corner cell has 3 neighbors).

Example: (21 = 4+17, 14 = 4+10, 10 = 4+6, 16 = 6+10, 22 = 6+16, etc for every value >2 of the grid)

```
21 14 10 16 22
17  4  1  6 19
12  3  5 11 13
15  8  2  7 18
23 24  9 20 25
```

It can be proven that there are 56816 such grids (or 7102 up to the 8 symmetries of the square).

In this problem, you are given a partially completed grid (in which unknown values are indicated by a 0 in the input) and you are asked to complete it.  
It is guaranteed for each given testcase that there exists a unique solution.

# Input
* 5 lines of 5 space-separated numbers between 0 and 25, 0 indicating an unknown value.

# Output
* 5 lines of 5 space-separated numbers between 1 and 25 corresponding to the unique complete solution.
