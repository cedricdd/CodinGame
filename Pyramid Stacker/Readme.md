# Puzzle
**Pyramid Stacker** https://www.codingame.com/training/easy/pyramid-stacker

# Goal
You are tasked with building a 3D pyramid using N toy cubes. The pyramid should have H layers, numbered from 1 (top) to H (bottom). Starting from the bottom layer, build layer i as follows:
* Mark out an ixi empty grid centred on the layers below.
* Place cubes in the grid using the given order of labels, filling row by row from back to front, and left to right within each row.
* Stop when all toy cubes have been placed, even if not all layers have been fully constructed.

After construction, display how the pyramid looks from the front. From this view, only the front-most cube(s) in each layer (if any) are visible.

Examples:  
H = 3, Toy cubes = ABCDEFGHIJKLMN (N = 14)
```
============ Top View ============   ======== Front View ========
   Layer 3       Layer 2   Layer 1
           v-- Back --v                    v-- Top --v
+---+---+---+                                 +---+
| A | B | C |   +---+---+                     | N |       Layer 1
+---+---+---+   | J | K |   +---+           +-+-+-+-+
| D | E | F |   +---+---+   | N |           | L | M |     Layer 2
+---+---+---+   | L | M |   +---+         +-+-+-+-+-+-+
| G | H | I |   +---+---+                 | G | H | I |   Layer 3
+---+---+---+                             +---+---+---+
          ^-- Front --^                  ^-- Bottom --^
```

H = 3, Toy cubes = ABCDEFGHIJKL (N = 12)
```
============ Top View ============   ======== Front View ========
   Layer 3       Layer 2   Layer 1
           v-- Back --v                    v-- Top --v
+---+---+---+                                 . . .
| A | B | C |   +---+---+                     .   .       Layer 1
+---+---+---+   | J | K |   . . .           +---+---+
| D | E | F |   +---+---+   .   .           | L | K |     Layer 2
+---+---+---+   | L |   .   . . .         +-+-+-+-+-+-+
| G | H | I |   +---+ . .                 | G | H | I |   Layer 3
+---+---+---+                             +---+---+---+
          ^-- Front --^                  ^-- Bottom --^
```

H = 3, Toy cubes = ABCDEFGHIJ (N = 10)
```
============ Top View ============   ======== Front View ========
   Layer 3       Layer 2   Layer 1
           v-- Back --v                    v-- Top --v
+---+---+---+                                 . . .
| A | B | C |   +---+ . .                     .   .       Layer 1
+---+---+---+   | J |   .   . . .           +---+ . .
| D | E | F |   +---+ . .   .   .           | J |   .     Layer 2
+---+---+---+   .   .   .   . . .         +-+-+-+-+---+
| G | H | I |   . . . . .                 | G | H | I |   Layer 3
+---+---+---+                             +---+---+---+
          ^-- Front --^                  ^-- Bottom --^
```

# Input
* Line 1: Two space-separated positive integers N and H.
* Line 2: N uppercase English letters (A-Z), denoting the labels of each toy cube (in order).

# Output
* H lines: The front view of the pyramid from layer 1 to layer H, where each line contains the visible cube labels of that layer (if any) separated by spaces.
* Each line should be centred according to the expected number of cubes in that layer, with all trailing whitespaces removed.

# Constraints
* 1 ≤ H ≤ 10
* 1 ≤ N ≤ H(H+1)(2H+1)/6
