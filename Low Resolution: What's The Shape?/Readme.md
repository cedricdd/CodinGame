# Puzzle
**Low Resolution: What's The Shape?** https://www.codingame.com/training/easy/low-resolution-whats-the-shape

# Goal
Nowadays, there are many ways to identify things in an image.  
However, given a very small image, which has only a few pixels, there are still some tricks to identify the shape in it, to further process it.  
You will try to find such a trick in this puzzle.  

In the images of this puzzle  
* '.' means empty.
*  'X' means full.
* All other characters means half-full.
  
In real usage, it would be an expression of "background is black, foreground is white, and this pixel is grey, so find any letter to express this middle value".

The program should identify 3 shapes:
```
1: Rectangle. It will cover all the image:
4×3:

XXXX
XXXX
XXXX
```

2: Triangle. At least one edge is along the image edge, and the opposite angle will be at the opposite edge of image:
```
6×3:

\XXXX/
.\XX/.
..\/..
```
```
8×3:

..../\..
../XXX\.
/XXXXXX\
```
```
4×3: (sometimes, the artist may choose to use 'X' and '.' only, as long as statements are satisfied)

X...
XXXX
X...
```
```
4×4:

\XXX
.\XX
..\X
...\
```

3: Ellipse. It will touch all edges of the image:
```
3×3:

/X\
XXX
\X/
```
```
8×7:

..XXXX..
.XXXXXX.
XXXXXXXX
XXXXXXXX
XXXXXXXX
.XXXXXX.
..XXXX..
```

Note: The 3 shapes are not generic, but all have some strong limitations. Base on them, there is one way that you do not need to detect edges or angles.

# Input
* Line 1: 2 integers W H for the width and height of image, separated by a space.
* Next H lines: The image. Each line have width W.

# Output
* One line containing Rectangle, Triangle or Ellipse.

# Constraints
* 3 ≤ W, H ≤ 10
