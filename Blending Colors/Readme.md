# Puzzle
**Blending Colors** https://www.codingame.com/training/easy/blending-colors

# Goal
Designers are placing shapes of different sizes and colors on the canvas of an image editor.

*About Colors*  
The shapes' colors are defined in RGB color notations. Red is (255, 0, 0); Green is (0, 255, 0); Blue is (0, 0, 255). Besides these, they also use Yellow (255, 255, 0), Cyan (0, 255, 255) and Magenta (255, 0, 255).  
All shapes have a thin black border (0, 0, 0) and are on a white background (255, 255, 255).

The shapes are defined as transparent so that when one shape is overlaying another, their colors will mix to reveal a new color.   
When two or more colors blend together, the new color is the average of all layer's colors.

For example, when R and G blend, the mixed color is (128, 128, 0). When Y, M and G mix, the result will be ((255+255+0)/3, (255+0+255)/3, (0+255+0)/3), which is (170, 170, 85). We round the decimal results to get the closest integers (i.e. 9.4 is regarded as 9; 9.5 is regarded as 10).

Black and White do not have blending effects.

In the final design, only squares and circles are used. Designers want to have a program to automatically calculate the color at any chosen point.

When a chosen point is within one or more shapes, report the color or mixed color at that point.  
When a chosen point is on the borderline of any shape, report Black (0, 0, 0).  
When a chosen point is outside the shapes, report White (255, 255, 255).  

# Input
* Line 1: Integer S and P, for the number of Shapes and number of checking points.

* Next S lines: Each line defines one Shape by seven elements, space separated:
  * name is either SQUARE or CIRCLE
  * x0 y0 are integers. For a circle, this is the coordinates of the center. For a square, it is the coordinates of the lower-left corner. 
  * We are using the Cartesian coordinates system. All square sides are parallel to the x or y axis.
  * len is an integer. For a circle, it is the radius. For a square, it is the side length.
  * R G B are integers, color values of this shape.

* Next P lines: Each line defines a point by integers x y. You have to calculate the color at each of the points.

# Output
* Write P lines Each line is a RGB color notation in format (R, G, B).

# Constraints
* 1 ≤ S ≤ 50
* 1 ≤ P ≤ 50
* 0 ≤ x, y ≤ 1000 (This is the canvas size limit)
* 1 ≤ len ≤ 500
* 0 ≤ R, G, B ≤ 255

Some shapes may be partially drawn outside the canvas. Your business is within the canvas only.
