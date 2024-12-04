# Puzzle
**Game of life** https://www.codingame.com/training/medium/game-of-life

# Goal
You are given a board with width * height cells in which each cell has an initial state: live '1' or dead '0'.   
Each cell interacts with its eight neighbors (horizontally, vertically and diagonally) using the following four rules:
1. Any live cell with fewer than two live neighbors dies, as if caused by under-population.
2. Any live cell with two or three live neighbors lives on to the next generation.
3. Any live cell with more than three live neighbors dies, as if by over-population..
4. Any dead cell with exactly three live neighbors becomes a live cell, as if by reproduction.

Write a program to compute the next state (after one update) of the board given its current state.

# Input
* Line 1: Two space separated integers width and height, respectively the width and height of the board
* Next height lines: width characters ('0' or '1') each representing an initial cell state.

# Output
* height lines: width characters ('0' or '1') each representing an updated cell state.

# Constraints
* 1 ≤ width, height ≤ 100
