# Puzzle
**L-triominoes** https://www.codingame.com/training/medium/l-triominoes

# Goal
The goal of the puzzle is to fill a square of side 2^n with L-triominoes, this is always possible if the square has a hole at the start...  
You are given the value of n and the coordinates (x,y) of the hole, your goal is to draw all the L-triominoes in the right places!  

Solve puzzle using divide and conquer method.

Divide the square into 4 equal squares.  
We are then reduced to 4 smaller problems identical to the previous one:
- One of the squares already has a hole somewhere
- Place a L-triomino in the center to create a new hole in the 3 other squares.

Exemple :
```
Test 2 : 4x4
2 : Level 2, it's a 4x4 grid
0 1 : The hole is in (0,1)

+--+--+--+--+
|  |  |  |  |
+--+--+--+--+
|##|  |  |  |
+--+--+--+--+
|  |  |  |  |
+--+--+--+--+
|  |  |  |  |
+--+--+--+--+
```

The hole is in top-left 2x2 square, so I have to solve 4 smaller problems...

* top-left 2x2 square with initial hole:
```
+--+--+        +--+--+
|  |  |        |     |
+--+--+   =>   +--+  +
|##|  |        |##|  |
+--+--+        +--+--+
```

* top-right 2x2 square with new hole:
```
+--+--+        +--+--+
|  |  |        |     |
+--+--+   =>   +--+  +
|##|  |        |##|  |
+--+--+        +--+--+
```

* bottom-left 2x2 square with new hole:
```
+--+--+        +--+--+
|  |##|        |  |##|
+--+--+   =>   +  +--+
|  |  |        |     |
+--+--+        +--+--+
```

* bottom-right 2x2 square with new hole:
```
+--+--+        +--+--+
|##|  |        |##|  |
+--+--+   =>   +--+  +
|  |  |        |     |
+--+--+        +--+--+
```

* join the 4 squares
```
+--+--+--+--+        +--+--+--+--+
|  |  |  |  |        |     |     |
+--+--+--+--+        +--+  +--+  +
|##|  |##|  |        |##|  |  |  |
+--+--+--+--+   =>   +--+--+  +--+
|  |##|##|  |        |  |     |  |
+--+--+--+--+        +  +--+--+  +
|  |  |  |  |        |     |     |
+--+--+--+--+        +--+--+--+--+
```

# Input
* Line 1: Level n, for a square of side 2^n
* Line 2: coordinates (x,y) of the hole. Note: (0,0) is the top left corner.

# Output
* 1 + 2^(n + 1) lines: The grid of L-triominoes

Hole:
```
+--+
|##|
+--+
```

L-triminoes:
```
+--+      +--+--+   +--+--+      +--+
|  |      |     |   |     |      |  |
+  +--+   +  +--+   +--+  +   +--+  +
|     |   |  |         |  |   |     |
+--+--+   +--+         +--+   +--+--+
```

# Constraints
* 1 <= n <= 3
* 0 <= x, y <= 2^n - 1
