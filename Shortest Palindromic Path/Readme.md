# Puzzle
**Shortest Palindromic Path** https://www.codingame.com/training/medium/shortest-palindromic-path

# Goal
You are given an NxN grid where each cell contains a single character. You are also given a start cell (startR, startC) and a goal cell (goalR, goalC). All coordinates use the format (row, column) and are 1-indexed.

A path is said to be palindromic if the concatenated string along the path is a palindrome.

Find the minimum length of a palindromic path from the start to the goal.

Path Rules:  
* The path length is the total number of cells in the path, including the start cell and the goal cell.
* Movement is restricted to 4-adjacent cells (up, down, left, right).
* The path does not have to be simple, meaning that it can visit the same cell more than once, subject to the self-loop rule below.
* No self-loops are allowed, meaning that the path may not visit the same cell twice (or more) consecutively.
* 
Example 1:  
Consider the following 3x3 grid:
```
abb
cda
edc
```

Let (1, 1) be the start cell and (2, 3) be the goal cell. The path (1, 1) → (1, 2) → (1, 3) → (2, 3) forms the string "abba", which is a palindrome. In this example, this is the shortest palindromic path from the start to the goal.

Example 2:  
Consider the following 5x5 grid:
```
aefba
bghcc
cccdi
jklmn
opqrs
```

A shortest palindromic path from (1, 1) to (1, 5) is (1, 1) → (2, 1) → (3, 1) → (3, 2) → (3, 3) → (3, 4) → (2, 4) → (2, 5) → (2, 4) → (1, 4) → (1, 5). In this case, the path length is 11, counting the cell (2, 4) twice. Note that you cannot move from (2, 4) to (2, 4) as self-loops are not allowed.

# Input
* Line 1: An integer N, representing the size of the grid.
* Line 2: Two space-separated integers startR and startC, representing the coordinates of the start cell.
* Line 3: Two space-separated integers goalR and goalC, representing the coordinates of the goal cell.
* Next N lines: A string of length N, representing each row of the grid.
  
# Output
* An integer representing the minimum length of a palindromic path from the start to the goal.

# Constraints
* 2 ≤ N ≤ 50
* 1 ≤ startR, startC, goalR, goalC ≤ N
* (startR, startC) ≠ (goalR, goalC)
* The grid contains only lowercase English letters.
* A palindromic path from the start to the goal is guaranteed to exist.
