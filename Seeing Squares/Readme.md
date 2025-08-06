# Puzzle
**Seeing Squares** https://www.codingame.com/contribute/view/131619994b5ea1cb546e665f881c6f9a83e83b

# Goal
Squares are regular geometric structures made up of 4 visually equal-length sides, where each pair of adjacent sides are orthogonal to each other. This puzzle introduces two types of squares: a small square (3 x 5) and a large square (5 x 9).
```
        +-------+
        |       |
+---+   |       |
|   |   |       |
+---+   +-------+
```

In each given figure, there will be a certain number of squares. Some squares may be adjacent to one another and may therefore have intersecting sides. An intersecting - and | character will always result in a + character.

Example figures and their corresponding number of squares
```
        +-------+       +-------+   +---+---+
        |       |       |       |   |   |   |
+---+   |       |   +---+       |   +---+---+
|   |   |       |   |   |       |   |   |   |
+---+   +-------+   +---+-------+   +---+---+
  1         1             2             5
```

Note that each side of a square must be clearly demarcated by characters |, -, and/or +.

Examples of non-squares
```
            +---+
            |   |
+---+   +---+   |
|       |       |
+---+   +-------+
```

Given any figure, can you "see" how many squares it contains?

# Input
* Line 1: Two space-separated integers R and C for the number of rows and columns of input.
* Next R lines: A single row of length C of the input figure.

# Output
* A single integer representing the total number of small and large squares in the figure.

# Constraints
* The input will only be made up of characters |, -, +, spaces, and newlines.
* There will only be at most two types of visually-equal squares in each figure: the small and large square.
