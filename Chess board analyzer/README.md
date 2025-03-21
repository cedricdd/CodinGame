# Puzzle
**Chess board analyzer** https://www.codingame.com/training/hard/chess-board-analyzer

# Goal
Find the winner (W or B) for the given chess board. If there isn't a King in checkmate position output N.

*You have to make several assumptions:*  
- The given boards are legal and are assuming the official Chess rules: https://en.wikipedia.org/wiki/Rules_of_chess
- In every board there is a winner (no draws) or the board is not terminal (the game could be continued)
- An attacked King could be saved only by moving himself to a safe square (not by using another piece from the King's team)
- White pawns are moving upwards, while black pawns are moving downwards

Example board:
```
........
.......k
........
........
........
......R.
.K.....R
........
```

In this example the white rooks (uppercase R letters) are attacking all the squares the black king (lowercase k letter) could move onto, so the black king is in checkmate position and the white (W) player wins.

# Input
* 8 lines: Each line contains 8 characters, which are representing a row on the board to analyze.

Characters can be:  
* . - Not occupied square on the board
* R - White Rook
* N - White Knight
* B - White Bishop
* Q - White Queen
* K - White King
* P - White Pawn
* r - Black Rook
* n - Black Knight
* b - Black Bishop
* q - Black Queen
* k - Black King
* p - Black Pawn

# Output
* W or B for the winning player or N if the game could be continued.
