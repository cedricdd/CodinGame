# Puzzle
**Magic Coloring** https://www.codingame.com/training/medium/magic-coloring

# Goal
Your nephew wants you to help him with his magic coloring. He doesn't want you to color for him, but rather to help him count the number of color blocks.

To do this, you've been given a set of simplified drawings. The drawings are grids of x columns and y rows. Each square can be either without color (white) 0, or colored with a color between 1 and 9 inclusive.

A "color block" is defined as all squares of the same color directly connected vertically or horizontally.

Example:
```
Here's a drawing:
00000
01120
00000
33340
```

Expected output format:
color number -> number of color blocks

In this example, there are 4 color blocks:
```
1 -> 1 (in the center with color 1 consisting of 2 cells)
2 -> 1 (in the right center with color 2 consisting of 1 cell)
3 -> 1 (at the bottom with color 3 consisting of 3 cells)
4 -> 1 (at the right bottom with color 4 consisting of 1 cell)
```

If you can't count some coloured blocks, explain to your nephew that : No coloring today

# Input
* Line 1: x and y which are the number of columns and rows of the drawing
* Next y Lines: A string of digits for one line of the drawing

# Output
* One Line per color number: color number -> number of color blocks sorted in ascending orderor One line: No coloring today

# Constraints
* 1 ≤ x ≤ 50
* 1 ≤ y ≤ 50
* 0 ≤ Number of different colors ≤ 9
