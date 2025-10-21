# Puzzle
**Sliding puzzle** https://www.codingame.com/training/expert/sliding-puzzle

# Goal
You are given a sliding puzzle containing W × H - 1 pieces.   
You need to find how many times you have to slide these pieces to reorder them from 1 at the top left to W × H - 1 just at the left of the bottom right corner (with the empty space at the bottom right).

For example, only one move is needed to solve the following puzzle (slide 7 to the left) :
```
1 2 3 4
5 6 . 7
```
2 moves are needed to solve the following puzzle (slide 3 to the left then 4 to the left) :
```
1 2 . 3 4
```

# Input
* Line 1 : The height H and width W of the puzzle.
* Next H Lines : A row of the puzzle (W numbers separated by a space). The empty space is marked with a dot .

# Output
* Line 1 : The number of moves needed to solve the puzzle.

# Constraints
* 1 ≤ W,H ≤ 10
* 0 ≤ Answer ≤ 10
