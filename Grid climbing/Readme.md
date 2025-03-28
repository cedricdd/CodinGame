# Puzzle
**Grid climbing** https://www.codingame.com/training/hard/grid-climbing

# Goal
You are given an integer n, an array costs of n-1 integers and a n times n grid of digits.  
You start at (0,0) with a starting cost equal to grid(0,0) and you want to reach the bottom right (n-1, n-1) with minimal cost.

At any turn you can move from (i, j) to (i', j') (different of (i, j)) in the grid with a cost equal to the sum of:
* the value of the grid at (i', j'), grid(i', j')
* the integer at the (d-1)-th index in costs table, where d = max(abs(i-i'), abs(j-j')).

Find the minimum cost.

Example:
```
3
1 5
132     X..
053  -> X..
011     .XX

starting cost = grid(0, 0) = 1
move (0, 0) -> (1, 0) = costs[1-1] + grid(1, 0) = 1 + 0 = 1
move (1, 0) -> (2, 1) = costs[1-1] + grid(2, 1) = 1 + 1 = 2
move (2, 1) -> (2, 2) = costs[1-1] + grid(2, 2) = 1 + 1 = 2
total = 1 + 1 + 2 + 2 = 6
```

# Input
* Line 1: An integer n for the number of points to compare.
* Line 2: A space separated string costs with n-1 elements, representing the cost of the distance.
* Next n lines: The rows of the n times n grid

# Output
* Line 1: An integer for the minimum cost required to reach the target.

# Constraints
* In costs, the n-1 integers satisfy: 0 < c_1 < c_2 < ... < c_(n-1)
* 3 <= n <= 20
