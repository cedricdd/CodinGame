# Puzzle
**Mondrian painting strokes** https://www.codingame.com/contribute/view/124524381d47463d8f9764cdd9253ad6bf98e0

# Goal
You are given a 2D grid representing a Mondrian-style painting.

Each rectangle in the painting is made up of adjacent cells with the same letter. A letter can be reused, as long as the rectangles it represents don't touch.

Your task is to compute the minimum number of black strokes needed to delimit all rectangles. A stroke is a continuous straight horizontal or vertical segment that separates two or more adjacent rectangles. The stroke must lie between two neighboring cells with different letters.

For instance, given the following grid:
```
ABB
CCC
```

There are 3 rectangles. They can be delimited with 2 strokes:  
- One vertical stroke between A and B
- One horizontal stroke between C and the row above
  
# Input
* First line: space-separated integers width and height for the width and height of the painting
* Next height lines: strings with width characters, each line representing a line in the painting

# Output
* A single integer N representing the minimum number of strokes necessary to draw all rectangles.
