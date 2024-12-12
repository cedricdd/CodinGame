# Puzzle
**How many triangles and rectangles?** https://www.codingame.com/training/hard/how-many-triangles-and-rectangles

# Goal
Find the number of triangles and rectangles in the ASCII art picture.  

A little rectangle:
```
+-+
|.|
+-+
```

Some little triangles:
```
+..+-+..+-+..+....+...+---+
|\..\|..|/../|.../.\...\./.
+-+..+..+..+-+..+---+...+..
```

# Input
* Line 1 : height h and width w of the ASCII art picture.
* h following lines: the content of the picture :
    * . for empty spaces
    * \+ for polygon corners
    * -, |, / or \ for strokes

# Output
* Line 1: Number of triangles
* Line 2: Number of rectangles

# Constraints
* 3 <= h <= 21
* 4 <= w <= 141
