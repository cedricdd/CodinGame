# Puzzle
**Where Was This Knight Before?** https://www.codingame.com/training/easy/where-was-this-knight-before

# Goal
You get two consecutive pictures of a game board. The board is made of 64 squares arranged in 8 rows and 8 columns. A single piece was moved:
* either to an empty square (simple move),
* or to a square occupied by another piece of the opposite player, in which case the target is removed from the board (move with capture).

Some AI already converted the pictures to ASCII art. Pieces may appear on the board in uppercase (white) or lowercase (black). Any character not in the set of valid piece letters (in either uppercase or lowercase) represents an empty square. Empty squares may be represented by different characters, even within the same board.

Your task is to output the move with its coordinates, and tell if the piece moved is a knight.

Knights are the only pieces on a chess board that do not move following a horizontal, vertical or diagonal pattern but move either 2 squares horizontally and 1 square vertically or 1 square horizontally and 2 squares vertically.

# Input
* Line 1 : A string pieces containing the uppercase letters (A-Z) that represent the white pieces. (The corresponding lowercase letters represent the black pieces.)
* Next 8 lines: The board before the move.
* Next 8 lines: The board after the move.
* Each line of the board is a string of 8 printable ASCII characters. Each character is either a piece or an empty square.

# Output
* Line 1: Coordinates of the initial and final squares of the piece that was moved.
  * Each coordinate is made of one lowercase letter (from a to h for the horizontal position on the board, from left to right) and one digit (from 1 to 8 for the vertical position, from bottom to top), the top left square being a8.
  * The coordinates shall be separated by - for a simple move, or x for a move with capture.
* Line 2: Knight if the moved piece is a knight, or Other

# Constraints
* Only one piece is moved and at most one piece can be captured. The moves are guaranteed to be simple, i.e. i no "en passant" move , nor pawn promotion, nor any castling.
* The string pieces contains at least one letter and at most 16.
