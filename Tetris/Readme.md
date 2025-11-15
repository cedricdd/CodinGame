# Puzzle
**Tetris** https://www.codingame.com/training/hard/tetris

# Goal
Given a Tetris shape and an existing playfield, your program must output the lowest position for that shape that will clear most lines without being rotated.

It is always possible to clear at least one line and the correct position is always accessible and valid: you do not need to ensure that a path effectively exists or that the shape is effectively resting on another one.

# Input
* Line 1:SW SH, the height and width of the shape description.
* SH next lines: one row of the shape
* Next line:FW FH, the height and width of the playfield description.
* FH next lines: one row of the playfield
* For both the shape and playfield descriptions, a block is represented by a '*' and an empty space is represented by a '.'.

# Output
* Line 1:X Y, the position of the top-left corner of the shape in the playfield.
* Line 2: N, the number of cleared lines.
* The Y axis starts at 0 on the bottom line of the playfield and increases upwards.

# Constraints
* 1 <= SW <= 4
* 1 <= SH <= 4
* 10 <= FW <= 20
* 1 <= FH <= 4
