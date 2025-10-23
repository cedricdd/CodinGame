# Puzzle
**TicTacToe** https://www.codingame.com/training/easy/tictactoe

# Goal
Find the winning move for the O player on the following tic-tac-toe board.

# Input
* 3 lines: a 3-character string (ex: ".OX") displaying the board current state
  * "." for an empty square
  * "X" for square occupied by X player
  * "O" for square occupied by O player

# Output
* 3 lines: a 3-character string (ex: ".OX") displaying the board state after an O winning move.
  * "." for an empty square
  * "X" for square occupied by X player
  * "O" for square occupied by O player
* If there is no winning move, print "false".

# Constraints
- The final board must be the input board plus a new square for O player.
- The board cannot be already in a won situation in the inputs.
