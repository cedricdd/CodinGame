# Puzzle
**3×N Tiling** https://www.codingame.com/training/medium/3n-tiling

# Goal
You are required to fill an K × N grid using the following pieces:

A 2×2 Piece:
```
┌───┐ 
│   │	 
└───┘
```
A 3×1 Piece which can be placed in two ways:
```
┌─────┐ 
└─────┘
┌─┐
│ │
│ │
└─┘
```
Given that K is always either 1, 2 or 3.

You have to output the total number of ways of doing this.

**Rules:** 
1. The entire grid must be filled i.e. there can be no empty cell.
2. No 2 tiles can overlap.
3. As already pointed above, the 3×1 Tile can be placed horizontally or vertically.
4. Since the answer might be large output it modulo 10⁹+7.
5. Note that there may also be 0 ways of filling a particular grid.

# Input
* Line 1: An integer T, the number of test cases
* Next T Lines: Integers K and N, the height and width of the grid respectively

# Output
* First T Lines: An integer W, the total number of ways of tiling the respective grid modulo 10⁹ + 7

# Constraints
* 1 ≤ T ≤ 10
* 1 ≤ K ≤ 3
* 1 ≤ N ≤ 10⁶
