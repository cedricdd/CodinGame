# Puzzle
**Cutting Corners** https://www.codingame.com/contribute/view/69348d46a0761af0fad4a42d13fe9d31870f7

# Goal
Here is a rectangle of size height by width, after someone sliced off a isosceles right triangle on all (or most) of the corners.

Figure out the non-hypotenuse sideOfTriangle of each triangle (As an example, the banner image has a red line to show the sideOfTriangle for the top right triangle.

This is trickier than it might appear because sometimes one triangle overlaps another.

Definition if needed:  
An isosceles right triangle is a type of right triangle whose legs (base and height) are equal in length.   
Since the two sides of the right triangle are equal in measure, the corresponding angles are also equal. Therefore, in an isosceles right triangle, two sides and the two acute angles are equal.

Source: https://www.splashlearn.com/math-vocabulary/isosceles-right-triangle#

# Input
* Line 1: Two integers: height of rectangle and width of rectangle (separated by a space)
* Next height lines Strings of length 2 * width - 1
* These lines include blank spaces so that the visual proportions appear correct.
* Together, these lines draw out the rectangle.

# Output
* Line 1: Two integers: sideOfTriangle of top left triangle, sideOfTriangle of top right triangle
* Line 2: Two integers: sideOfTriangle of bottom left triangle, sideOfTriangle of bottom right triangle

(All integers are separated by a space)

# Constraints
* 0 ≤ sideOfTriangle
* sideOfTriangle < height
* sideOfTriangle < width
* height, width are odd numbers
* 7 ≤ height, width ≤ 95
