# Puzzle
**Frame the picture** https://www.codingame.com/training/easy/frame-the-picture

# Goal
The goal of this exercise is to draw a ASCII art frame around a given ASCII art picture.  
Always leave one space between the edges of the given picture and the frame. Also remember to rotate the frame pattern around the picture.

For instance, if the frame pattern is:
```
+.
```

The frame should look like this:
```
+++++++
+.....+
+.   .+
+. P .+
+.   .+
+.....+
+++++++
```

# Input
* Line 1: the ASCII art pattern to use to frame the picture
* Line 2: the height h and the width w of the picture
* Next h lines: the ASCII art picture

# Output
* Framed ASCII art picture.

# Constraints
* pattern length is <= 10
* 1 <= h <= 10
* picture line length is <= 50
