# Puzzle
**Long Palindromic Path** https://www.codingame.com/contribute/view/1387470f2e91c15e164db756ef163819c5862d

# Goal

You are given the size N of a grid, a start cell (startR, startC). All coordinates use the format (row, column) and are 1-indexed.

A path is said to be palindromic if the concatenated string along the path is a palindrome.

Construct an NxN grid by assigning a single character to each cell and choose a goal cell (goalR, goalC) such that the following five conditions are satisfied:
* The grid contains only lowercase English letters.
* 1 ≤ goalR, goalC ≤ N
* (startR, startC) ≠ (goalR, goalC)
* A palindromic path from the start to the goal exists.
* The minimum length of a palindromic path from the start to the goal is exactly N^2.

Under the given constraints, it can be proved that a valid grid always exists.

Path Rules:
* The path length is the total number of cells in the path, including the start cell and the goal cell.
* Movement is restricted to 4-adjacent cells (up, down, left, right).
* The path does not have to be simple, meaning that it can visit the same cell more than once, subject to the self-loop rule below.
* No self-loops are allowed, meaning that the path may not visit the same cell twice (or more) consecutively.

Example 1

The following 4x4 grid is a valid grid for N=4, (startR, startC)=(1, 1). The chosen goal is (4, 3).
```
abcd
hgfe
hedc
gfab
```

The path (1, 1) → (1, 2) → (1, 3) → (1, 4) → (2, 4) → (2, 3) → (2, 2) → (2, 1) → (3, 1) → (4, 1) → (4, 2) → (3, 2) → (3, 3) → (3, 4) → (4, 4) → (4, 3) forms a palindrome "abcdefghhgfedcba". This path has length 16 and is the shortest palindromic path from the start to the goal.

Example 2

The following 4x4 grid is a valid grid for N=4, (startR, startC)=(1, 2). The chosen goal is (3, 1).
```
aaac
cbca
aabb
caaa
```
A shortest palindromic path is (1, 2) → (1, 1) → (1, 2) → (1, 3) → (1, 2) → (2, 2) → (3, 2) → (3, 3) → (3, 4) → (4, 4) → (3, 4) → (4, 4) → (4, 3) → (4, 2) → (3, 2) → (3, 1). In this case, the cell (1, 2) is counted three times. Similarly, other cells are counted multiple times if they are visited multiple times. Note that you cannot move from (1, 2) to (1, 2) as self-loops are not allowed.

Note:
* This puzzle tasks you with generating specific test cases for the Shortest Palindromic Path puzzle. It is recommended to solve that puzzle first. Please feel free to reuse your code.
* You can hide trails in the settings panel.

# Input
* Line 1: An integer N, representing the size of the grid.
* Line 2: Two space-separated integers startR and startC, representing the coordinates of the start cell.

# Output
* Line 1: Two space-separated integers goalR and goalC, representing the coordinates of the goal cell.
* Next N lines: A string of length N, representing each row of the grid.

# Constraints
* 4 ≤ N ≤ 20
* 1 ≤ startR, startC ≤ N
* For N ≥ 9, (startR, startC) is none of (2, 2), (2, N - 1), (N - 1, 2), or (N - 1, N - 1).
* For odd N ≥ 9, startR + startC is even.
* The execution time limit is 25 seconds.
