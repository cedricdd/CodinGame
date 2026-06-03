# Puzzle
**Chess moves on FEN position** https://www.codingame.com/training/hard/chess-moves-on-fen-position

# Goal
Make several moves on a chessboard and print the final position as an FEN string.
```
8 r n b q k b n r
7 p p p p p p p p
6 . . . . . . . .
5 . . . . . . . .
4 . . . . . . . .
3 . . . . . . . .
2 P P P P P P P P
1 R N B Q K B N R
  a b c d e f g h
```

The above position is represented in FEN by the string: ```rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR```

FEN describes a Chess Position with a one-line ASCII string.  
The piece placement is determined rank-by-rank, starting at rank 8 and proceeding down to rank 1.  
Each rank string is separated by the terminal symbol '/' (slash).  
Each rank string scans piece placement from column a to column h.  
A decimal digit counts consecutive empty spaces.  
The pieces are identified by a single letter. (k=king, q=queen, r=rook, b=bishop, n=knight, p=pawn)  
Uppercase letters are for white pieces, lowercase letters for black pieces.  

The moves you have to make are defined by a string with either 4 or 5 chars, where:
- The first two chars represent the starting square,
- The next two chars represent the target square and
- The last (optional) char represents the piece you get if / when a pawn promotion occurs.

Example: "e7e8Q" - you must remove the pawn on the e7 square and place a white queen on the e8 square.

Example: "e1g1" - you must remove the king on the e1 square and place it on the g1 square. But a king can't move more than 1 square unless he is castling, so you must also move the rook on the h1 square to the f1 square in order to complete the castling move.

Example: "h5g6" - you must remove the pawn on the h5 square and place on the g6 square. If there is not a piece on g6 but there is a pawn on g5 then you must remove the pawn on g5 in order to complete the "en passant" move.

Note:  
All the moves are legal and can be made following standard chess rules.

# Input
* Line 1: An FEN string B describing the initial board position.
* Line 2: An integer N for the number of moves to make.
* Next N lines: A string M for the coordinates (and optional promotion piece) of a move.

# Output
* Line 1: An FEN string describing the final board position.

# Constraints
* 1 ≤ N ≤ 100
