# Puzzle
**Binary Image** https://www.codingame.com/training/easy/binary-image

# Goal
You are going to write a simple program to decode some arrays of data into a black-and-write graphic.

The graphic is composed of n lines of black and white pixels. We use . to represent a white pixel; O to represent a black pixel.

For example, here is one line of graphic  
....OOO.

We shall encode it into an array 4 3 1  
because it starts with 4 whites, then 3 blacks, then 1 white.  
We assume most lines shall start with white.  

When there is a line starting with black, we add 0 at the beginning of the encoded data, to say there is no white pixel before the first black pixel.  
For example  
OO.OOOOO  
will be encoded into 0 2 1 5.  

You must output INVALID if the graphic is not rectangular (this doesn't mean the input lines should be the same length, but the outputs lines should be).

In this puzzle, you will be given n lines of encoded data.  
You are going to decode it into a graphic.

# Input
* First line : Number n of rows in the graphic (integer)
* n next lines : An array of integers representing the encoded nth line of the graphic

# Output
* If the grid is not a rectangle : INVALID
* Otherwise : n lines of the grid (equal length), each pixel represented by ./O, no spaces

# Constraints
* n < 200
