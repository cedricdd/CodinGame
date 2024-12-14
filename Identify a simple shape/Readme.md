# Puzzle
**Identify a simple shape** https://www.codingame.com/training/medium/identify-a-simple-shape

# Goal
Recognize the shape made up of # and give the coordinates of the corners

The possible shapes are:  
* POINT
* LINE
* EMPTY TRIANGLE
* FILLED TRIANGLE
* EMPTY SQUARE
* FILLED SQUARE
* EMPTY RECTANGLE
* FILLED RECTANGLE

Coordinates:  
* (0,0) is top left
* (19,0) is top right
* (0,19) is bottom left
* (19,19) is bottom right

# Input
* 20 lines of 39 characters ( . or # separated by spaces)

# Output
* One line: Shape and coordinates (x,y) of the corners, ordered in ascending order of x then y. (separated by spaces)

# Constraints
* Only one shape per test

(no ambiguous cases of very small triangles, squares and rectangles)
