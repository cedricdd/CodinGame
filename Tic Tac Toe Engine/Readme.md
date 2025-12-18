# Puzzle
**Tic Tac Toe Engine** https://www.codingame.com/training/medium/tic-tac-toe-engine

# Goal
Tic Tac Toe (also known as noughts and crosses or Xs and Os) is a paper-and-pencil game for two players who take turns marking the spaces in a 3x3 grid, one with Xs and the other with Os. The player X always goes first.

The objective is to be the first to align three marks in a row, column, or diagonal. A player wins when this condition is met, loses if the opponent achieves it first, and the game ends in a draw if all nine cells are filled without a winner.

Your task is to develop a Tic Tac Toe engine that always plays the best possible move. On its turn, the engine must choose the move that maximizes its chance of winning, or forces a draw, or delays a loss. In a winning position, the engine should choose the move that wins in the fewest number of turns. Likewise, in a losing position, the engine should choose the move that loses in the most number of turns.

If multiple moves are equally optimal (wins/draws/loses in the same number of turns), the engine should select its move based on the highest available cell value, which is defined by the following grid. The cell values prioritize playing in the center, followed by the 4 corners, and finally the remaining 4 cells.
```
 8 | 4 | 7 
---+---+---
 3 | 9 | 2 
---+---+---
 6 | 1 | 5 
```

Lastly, the engine should not make any move if the game has already been won by either player or if the board is completely filled.

# Input
* Line 1: The engine player engine; either X or O.
* Next 3 lines: Exactly 3 characters. Each character is either X, O, or . (empty space).
 
# Output
* 3 lines of exactly 3 characters, representing the 3x3 tic tac toe board after the engine has made its move. If the game is already over, output the board unchanged.

# Constraints
* The given board will always be valid. If engine is X, there will always be an equal number of Xs and Os. Else, there will always be one more X than O.
