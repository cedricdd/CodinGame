# Puzzle
**ASCII cube** https://www.codingame.com/training/medium/ascii-cube

# Goal

Your goal is to output a cube of dimensions w × h × d in ASCII Art, oriented so that the front face is in the direction of bottom left.  
Therefore, the three visible faces are the front, the top and the right.  
The visible edges are represented with the characters /, \ and _.  
You'll have to draw the hidden edges too, with the characters ⠌, ⠡ and ..  

# Notes
* ⠌ or ⠡ are characters from braille alphabet. Their unicode are 0x280c and 0x2821, respectively.
* Because a console character is higher than large, a unit of 1 w (width) is represented with two characters instead of one (__ or ..).
* If a visible face has a width, a height or a depth of 1, you won't have to draw the hidden edges behind this face.
* If a solid line and a dotted line are layered on the same character, the priority always goes to the solid line, except for a hidden oblique edge (⠌ or ⠡), which must replace a visible horizontal edge (_) (see examples below).

*Examples*  
```
Input:
w = 4
h = 2
d = 4
```

```
Output:
    ________
   /⠡      /\
  /  ⠡..../..\
 /   ⠌   /   /
/___⠌___/   /
\  ⠌    \  /
 \⠌______\/
```

```
Input:
w = 6
h = 2
d = 2
```

```
Output:
  ____________
 /⠡          /\
/__⠡________/..\
\  ⠌        \  /
 \⠌__________\/
```

```
Input:
w = 1
h = 1
d = 1
```

```
Output:
 __
/_/\
\_\/
```

# Input
* Line 1: An integer w for the width.
* Line 2: An integer h for the height.
* Line 3: An integer d for the depth.

# Output
* An ASCII Art of a cube of dimensions w × h × d.

# Constraints
* w, h, d > 0
