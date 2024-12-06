# Puzzle
**Harmless Rooks** https://www.codingame.com/training/hard/harmless-rooks

# Goal
The rook is a chess piece that can move along its current line (horizontally) or column (vertically) through any number of free (unoccupied) squares.

In this problem, we consider an N × N generalized chess board where the squares are either free (. in the input) or already occupied (X in the input) and hence cannot be crossed by the rooks.

Compute the maximum number of rooks that can be placed on free squares in such a way that no two rooks threaten each other (hence two rooks on the same line/column must be separated by at least one occupied square).

# Input
* Line 1: An integer N, the size of the square board.
* Next N lines: A string of length N describing a line of the board, . indicates a free square and X an occupied one.

# Output
* A single integer corresponding to the maximum number of rooks that can be placed on free squares without directly threatening each other.

# Constraints
* 1 ≤ N ≤ 99
