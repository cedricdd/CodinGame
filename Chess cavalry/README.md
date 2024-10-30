# Puzzle
**Chess cavalry** https://www.codingame.com/training/hard/chess-cavalry

# Goal
You need to move a chess knight between the points B and E.

A chess knight moves in an L shaped pattern, like so:
```
.X.X.
X...X
..B..
X...X
.X.X.

```
The Xs mark where the knight in position B can move.

There may be other chess pieces on the board, blocking the knight's movement, but for clarity, you will only be notified of where you cannot go by # characters. You cannot land on these marked spaces, but you can go over them. You also cannot go outside of the board.

Your goal is to find how many turns N are needed to go from B to E, or return Impossible if it can't be done.

# Input
* Line 1: Two integers W and H giving the width and height of the board.
* H next lines: A row of the board, containing the characters B, E, . and #

# Output
* One line, giving the minimum number of turns N needed to go from B to E, or Impossible.

# Constraints
* 2 ≤ W, H ≤ 8
