# Puzzle
**Optimized coloring** https://www.codingame.com/training/medium/optimized-coloring

# Goal
Having an empty sheet of paper divided in some zones, try to fill these zones with as few colors as possible, respecting the following rule : two adjacent zones must be filled with two different colors.

Two zones are considered as adjacent if they share, at least partially, a border.

For instance, these pairs of zones are adjacent :
```
+---+         +---+
|   +---+     |   |
+---|   |     +-+-+-+
    +---+       |   |
                +---+
```

Warning : two zones touching diagonally are not adjacent.

For instance, these zones are not adjacent :
```
+---+
|   |
+---+---+
    |   |
    +---+
```

You have to find the minimum number of colors necessary to fill all the zones.

# Input
* Line 1: an integer w representing the width of the sheet of paper
* Line 2: an integer h representing the height of the sheet of paper
* h following lines : a string representing one line of the sheet of paper

# Output
* Line 1: an integer representing the minimum number of colors necessary to fill the sheet of paper

# Constraints
* w < 100
* h < 20

You can find the following symbols in the input : -, |, +, /, \ and _
