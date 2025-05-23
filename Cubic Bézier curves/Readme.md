# Puzzle
**Cubic Bézier curves** https://www.codingame.com/training/easy/cubic-bezier-curves

# Goal
Bézier curves are used everywhere in computer design because they are handy and easy to use, but they are also easy to calculate!

Your task is to draw a Bézier curve using ASCII characters: To create a cubic Bézier curve, you need a starting point A (Ax, Ay), two control points B (Bx, By) and C (Cx, Cy) and an ending point D (Dx, Dy).  
Then, you have to perform some linear interpolations:  
* Interpolate A and B to get one point AB (and repeat for BC and CD).
* Interpolate AB and BC to get one point ABC (and repeat for BCD).
* Interpolate ABC and BCD to get one point of the Bézier curve.

The formula to perform a linear interpolation "I" given 2 points P,Q and one weight t is: I=P*(1-t) + Q*t.

Since the curve could have infinite resolution, we provide the amount of interpolation steps that have to be used. For example, if there are 3 steps, you will have to calculate the points for the weights of 0, 0.5 and 1 (since the interpolation weights can range from 0 to 1, 0 being the starting point and 1 being the ending point).

The width and height of the canvas are also provided. The origin (0, 0) is always the bottom-left corner and the coordinates are positive integers between [0, width-1] for X and [0, height-1] for Y.

For each of the height lines, you'll need to print:  
- A point "." as the first character.
- "#" at every coordinate where there is a point of the curve. If it coincides with a reference point ".", "#" has more preference.
  
Multiple curve points could fall on the same coordinate (they would be represented still as a "#").   
The coordinates of the points of the curve are the rounded integers of the last interpolation results (0.5 is always rounded to the higher integer).  
- Blank spaces " " to separate all the characters (as many as needed). Don't add extra spaces after the last curve (or reference) point!

# Input
* Line 1: The size of the canvas width, height.
* Line 2: The number of interpolation steps.
* Line 3: Starting point Ax, Ay.
* Line 4: Control point Bx, By.
* Line 5: Control point Cx, Cy.
* Line 6: Ending point Dx, Dy.

# Output
* height lines of length width to represent the canvas.

# Constraints
* 10 ≤ width,height ≤ 50
* 2 ≤ steps ≤ 100
* 0 ≤ Ax,Bx,Cx,Dx < width
* 0 ≤ Ay,By,Cy,Dy < height
