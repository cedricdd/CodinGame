# Puzzle
**Scaleable TicTacToe** https://www.codingame.com/training/easy/scaleable-tictactoe

# Goal
Imagine you're looking at a game of TicTacToe, but this time, the board can be any size, and the players need more than just three in a row to win. You're given a snapshot of the game, and it's your job to figure out if someone has already won, if the game is still going, or if it's ended in a draw, and then clearly mark the winning path if there is one.

On input, you are given two integers: n for the size of the TicTacToe board, and g for the number of cells required for a winning path. You are also given the state of a TicTacToe game, where:
* (space) means that this cell is empty,
* X means that it is occupied by player X and
* O means that it is occupied by player O.

The winning path must be g cells long, according to the normal rules of TicTacToe (connecting g cells occupied by the same player in a row, column or diagonal).

Your task is to output two things. The first output is the same TicTacToe game, but the winning path will be represented using the characters:
* \- (if the winning path is in a row),
* | (if the winning path is in a column),
* / (if the winning path is in a diagonal from left bottom to right top), or
* \ (if the winning path is in a diagonal from left top to right bottom).
If there is no winning path, then the same field is output as was in an input.

The second output is the result, which will be one of the following:
* The game isn't over yet! if there is at least one empty space and no winner,
* The winner is X. if X won,
* The winner is O. if O won, or
* The game ended in a draw! if nobody won and there is no empty space.


It is not necessary for players X and O to have occupied the same number of spaces.

# Input
* Line 1: Two space-separated integers n and g for the size of the TicTacToe board, and the number of cells required for a winning path respectively
* Next n lines: Each line contains n characters for the state of one row of the TicTacToe board

# Output
* n lines: The TicTacToe board updated with the winning path (if applicable)
* Next line: The game isn't over yet! or The winner is X. or The winner is O. or The game ended in a draw!

# Constraints
* 2 < n <= 12
* 2 < g <= n
* There can't be more than 1 winning path.
* The winning path will always be g spaces.
