# Puzzle
**Seeing Squares** https://www.codingame.com/training/easy/seeing-squares

# Goal

Squares are regular geometric structures made up of 4 visually equal-length sides, where each pair of adjacent sides are orthogonal to each other. In this puzzle, your task is to identify ("see") the number of squares in any given figure.

This puzzle uses ASCII characters to "draw" figures containing squares. Specifically, horizontal lines are denoted by -, while vertical lines are denoted by |. A + character denotes the meeting point of - and | characters, which represent a connection in both the horizontal and vertical directions.

To ensure visual "equal-ness" of square sides, a square of (vertical) height h must have a (horizontal) length of 2h - 1; h > 1.

Different square sizes  
(These are just examples; squares can grow as big as the grid allows them to)
```
                           +-------+
                 +-----+   |       |
         +---+   |     |   |       |
   +-+   |   |   |     |   |       |
   +-+   +---+   +-----+   +-------+
h   2      3        4          5
```

To count squares that are fully enclosed:
- The corners of squares must be + characters.
- Each horizontal side of a square must be made up of -/+ characters.
- Each vertical side of a square must be made up of |/+ characters.

Examples of non-squares
```
            +---+
            |   |
+---+   +---+   |
|       |       |
+---+   +-------+
```

Note that some squares may be adjacent to / overlap one another, and may therefore have intersecting sides.

Example figures and their corresponding number of squares
```
+-------+       +-------+   +---+---+   +-+           +-----+
|       |       |       |   |   |   |   +-+-+-+       |  +--+--+
|       |   +---+       |   +---+---+     +-+ +---+   |  |  |  |
|       |   |   |       |   |   |   |     +---+   |   +--+--+  |
+-------+   +---+-------+   +---+---+         +---+      +-----+
    1             2             5            4             2
```

# Input
* Line 1: Two space-separated integers R and C for the number of rows and columns of input.
* Next R lines: A single row of length C of the input figure.

# Output
* A single integer representing the total number of squares (of all sizes) in the figure.

# Constraints
* 1 ≤ R,C ≤ 100
* The input will only be made up of characters |, -, +, spaces, and newlines.

