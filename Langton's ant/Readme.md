# Puzzle
**Langton's ant** https://www.codingame.com/training/medium/langtons-ant/solution

# Goal
Langton's ant is a turing machine built on simple rules:
* Consider a grid of WxH squares, each of which can be either black # or white ..
* The ant starts at the position (x, y) of the grid, the upper left square coordinates are (0,0).
* The ant is facing one of the following directions (N = up, E = right, S = down, W = left).
* The ant moves T turns. For each turn:
    * it rotates 90° left if it is on a white square, 90° right otherwise.
    * it inverts the color of the square it is located on.
    * it moves 1 square forward in its current direction.

From an arbitrarily coloured grid and the ant's initial state, you have to print the grid state after T turns.

On the given test cases, the ant never has to go out of bounds.

# Input
* Ligne 1 : Two integers W and H for the width and height of the grid.
* Ligne 2 : Two integers x and y for the ant's initial coordinates.
* Ligne 3 : A character N, E, S or W for the ant's initial direction.
* Ligne 4 : An integer T for the number of turns.
* H following lines : A line of size W composed of # (black square) and . (white square) for the initial state of the grid.

# Output
* H lines representing the final state of the grid.

# Constraints
* 1 ≤ W, H ≤ 30
* 0 ≤ x < W
* 0 ≤ y < H
* 0 ≤ T ≤ 1000
