# Puzzle
**Squares order** https://www.codingame.com/training/expert/squares-order

# Goal
Squares have been drawn with ASCII characters on a grid.  
The objective is to find each of their sizes and in which order they were drawn.  
(Each square overlaps another one.)  

# Input
* Line 1 : h the height and w the width of the grid.
* Line 2 : nb the number of squares.
* h following lines : the content of the grid. '.' for an empty spot, and a label (between 1 and nb) representing the border of the squares.

# Output
* nb lines giving in drawing order.
* The label and size of each square, separated by a space, in order from the first one drawn to the last.

# Constraints
* 2 ≤ h, w ≤ 10
* 1 ≤ nb, label ≤ 5
* 2 ≤ size ≤ 10
