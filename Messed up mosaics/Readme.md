# Puzzle
**Messed up mosaics** https://www.codingame.com/training/easy/messed-up-mosaics

# Goal
I ordered beautiful mosaics online.  
They were cheap, but they all came with the same issue: one single tile is not the good one.  

Can you help me locate the wrong tile in each mosaic?  

Each mosaic is made of N * N tiles.  
Given a pattern of tiles that repeats to form a mosaic and the mosaic itself, you have to find the coordinates of the tile that doesn't fit the pattern.  
The origin of the coordinates is at the top left corner of the mosaic.  

# Input
* Line 1: An int N for the length (in tiles) of the side of the square mosaic.
* Line 2: A string pattern for the pattern of tiles that form the mosaic.
* Next N lines: a string that constitutes a row of the mosaic.

# Output
* A single line containing the coordinates of the wrong tile, formatted as (x,y)

# Constraints
* There is only one wrong tile in the mosaic.
* The mosaic is always wider than the pattern.
