# Puzzle
**Who won and where? Scaleable TicTacToe** https://www.codingame.com/contribute/view/93175882405a872ba1077479ecb34fc2fc8b1

# Goal
On input, you'll be given two integers n and g separated by spaces, and n lines, each containing n characters. These n lines will represent a state of a TicTacToe game, where (space) means that this cell is empty, X means that it is occupied by player X and O means that it is occupied by player O. The winning path must be at least g cells long, according to the normal rules of TicTacToe (connecting g in a row, column or diagonal).

On the output, there will be n lines with the same TicTacToe game, but the winning path will be represented using the characters - (if the winning path is in a row), | (if the winning path is in a column), / (if the winning path is in a diagonal from left bottom to right top) or \ (if the winning path is in a diagonal from left top to right bottom). If there is no winning path, then the same field is output as was in an input.
The next line will be one of the following The game isn't over yet! if there is at least one empty space and no winner, The winner is X if X won, The winner is O if O won, or The game ended in a draw! if nobody won and there is no empty space.

It is not necessary for players X and O to have occupied the same number of spaces.

# Input
* Line 1: An integer n and g
* Next n lines: n characters

# Output
* n lines: n characters
* Next line: The game isn't over yet! or The winner is X. or The winner is O. or The game ended in a draw!

# Constraints
* 2 < n <= 12
* 2 < g <= n
* There can't be more than 1 winning path.
* The winning path will always be g spaces.
