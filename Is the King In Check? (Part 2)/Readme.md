# Puzzle
**Is the King In Check? (Part 2)** https://www.codingame.com/training/medium/is-the-king-in-check-part-2

# Goal
Part 2 of a series, please solve Part 1 first to understand this problem fully https://www.codingame.com/training/easy/is-the-king-in-check-part-1

8 x 8 space-separated character rows of a chessboard with three pieces on the board. Your King and two enemy pieces.   
Print "Check" or "No Check" depending on whether one of the enemy pieces is able to attack your king on the next turn   
(remembering that pieces that are 'in the way' of an enemy's line of attack at your king will block each other - excluding Knights which can't be blocked).

The King will be a k character (Note: it was "K" in the previous challenge, please update your code).   
The possible enemy pieces are Bishop (B), Knight (N), Rook (R) or Queen (Q). The empty positions will be _ in the input.   
The only two non-_ characters will be k and two of B/N/R/Q.  

Bishops (B): Attack diagonally in all four directions.  
Rooks (R): Attack horizontally/verically in all four directions (can attack along same row or column)  
Queens (Q): Attack in all eight of the above directions.  

Knights (N): Attack in L-shapes - squares that are two rows and one column away (L), or one row and two columns away (∟).   
(These happen to be the only eight squares in a 5x5 sub-grid that a Queen can't attack from the same spot).

```
Example
_ _ _ _ _ _ _ _
_ _ _ Q _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ N _ _ _ _
_ k _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
```

In the above diagram, the Queen is not able to attack the King, but the Knight is, so the repsonse is "Check".

```
Example
_ _ _ _ _ _ _ _
_ k N _ Q _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _
_ _ _ _ _ _ _ _

```

Here the Queen would be able to attack the King if it weren't for the fact that the Knight is in the way.  
The knight cannot attack the king either so the answer is "No Check".

# Input
* 8 lines of : 8 space-separated characters, mostly underscores with exactly one k and two of B/N/R/Q.

# Output
* 1 line : "Check" if the King is in check (by either enemy) or "No Check" if not.

# Constraints
* Always three pieces on the board. Only non-space characters in input are _, one k and two of B/N/R/Q. Always an 8x8 size board, always three pieces.
