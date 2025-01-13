# Puzzle
**Nature of quadrilaterals** https://www.codingame.com/training/easy/nature-of-quadrilaterals

# Goal
You have to print the nature of the quadrilaterals whose vertices’ coordinates are given.  
The nature can be:
* nothing, in which case you should write "quadrilateral",
* parallelogram (opposite sides are parallel to each other),
* rhombus (all four sides are equal),
* rectangle (all four angles are right) or
* square (it is a rectangle and a rhombus).

# Input
* Line 1: The number of quadrilaterals (n)
* Next n lines: Each vertex followed by its coordinates, one quadrilateral per line. In the format: A xA yA B xB yB C xC yC D xD yD

# Output
* The name of the quadrilateral followed by its nature.
* The vertices are printed in the given order. Note that ABCD, ABDC and ACBD are three distinct quadrilaterals. Just follow the order of the vertices.
  
For example:  
ABCD is a rhombus.  
DEFA is a quadrilateral.  

# Constraints
* The coordinates are integers between -20 and 20, you have no more than 3 quadrilaterals.
* You won’t have to test if a quadrilateral is degenerate or convex.
