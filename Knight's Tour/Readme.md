# Puzzle
**Knight's Tour** https://www.codingame.com/contribute/view/156963dbc977d1acc724a58d71dcf6d4f87c91

# Goal
In this puzzle, you will implement a deterministic version of the famous Knight's Tour problem.

Your goal is to find a sequence of moves that allows a chess knight to visit every square on the board exactly once, without revisiting any square.

A knight moves in an L-shape: two squares horizontally and one vertically, or two squares vertically and one horizontally.

To construct the route, you must use Warnsdorff's Rule:  
1. At each step, consider all unvisited squares that the knight can legally move to.
2. For each candidate square, count how many unvisited squares the knight could move to from there.
3. Choose the candidate with the smallest count.
4. If several candidates have the same count, choose the one with the smallest row index. If their row indices are equal, choose the one with the smallest column index.
5. Mark the chosen square as visited and repeat until all squares have been visited or no legal move remains.

The top-left cell of the board has coordinates (0, 0). Row indices increase from top to bottom↓, and column indices increase from left to right→.

# Input
* Line 1: An integer n representing the side length of the chessboard.
* Next n lines: Each line contains n characters representing a row of the board.
  . represents an empty cell, and K represents the knight's starting position.

# Output
* Print the resulting chessboard as n lines, each containing n integers separated by spaces.
* Each integer represents the order in which the knight visits that square, starting with 0 at the knight's initial position and ending with n×n - 1.

# Constraints
* 5 ≤ n ≤ 16
* The board contains exactly 1 knight.
* For all provided test cases, a complete route exists when following the specified rules.
