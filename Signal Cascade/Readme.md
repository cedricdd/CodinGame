# Puzzle 
**Signal Cascade** https://www.codingame.com/contribute/view/1508586bd621271401005e38900483f7bb966c

# Goal
This puzzle is about chain reactions and propagation.  
Your task: You are given a grid containing numbers.  
Each number represents the initial energy of a cell.  

Every time a cell receives a signal, its energy increases by 1.  
If the energy becomes greater than 9, the cell overloads:  
* Its energy resets to 0.
* It sends the signal to all 8 neighboring cells (including horizontal, vertical and diagonal) except previously overloaded cells.

If several cells overload simultaneously, they may be processed in any order and should give the same result.

Your task is to simulate the cascade until no more overloads occur and output the final grid.

# Input
* Line 1: Two space-separated integers H and W, the height and width of the grid.
* Next H lines: Each line contains W digits (0–9) representing one row of the grid.
* Next line: Two space-separated integers R and C, the row and column indexes (0-based) of the starting cell receiving the initial signal.

# Output
* H lines: The final grid after the cascade.

# Constraints
* 1 ≤ H, W ≤ 10
* 0 ≤ R < H
* 0 ≤ C < W
