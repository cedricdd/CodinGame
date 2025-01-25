# Puzzle
**Number of triangles enclosing X** https://www.codingame.com/training/medium/number-of-triangles-enclosing-x

# Goal
Given a point X in an orthonormal coordinate system, you must find the number of triangles formed by the other given points in which X is inside.

Example 1  
```
INPUT  REPRESENTATION  OUTPUT  COMMENT
X 2;3  B(1;5)          1       X is inside the triangle ABC
3      |\
A 1;1  | \
B 1;5  |  \
C 5;1  | x(2;3)
       |    \
       |_____\
       A(1;1) C(5;1)
```

Example 2
```
INPUT  REPRESENTATION  OUTPUT  COMMENT
X 2;3  B(1;5)  D(5;5)  2       X is inside the triangles ABC and ABD
        _____
4      |\    /|
A 1;1  | \  / |
B 1;5  |  \/  |
C 5;1  | x(2;3)
D 5;5  | /  \ |
       |/____\|
       A(1;1) C(5;1)
```

# Input
* Line 1: X x;y string for the coordinates of point X. x and y are floats.
* Line 2: an integer n for the number of points to read.
* Next n Lines p x;y for the points with their coordinates used to build triangles, x and y are floats.

# Output
* c Number of triangles where X is inside.

# Constraints
* The triangles ABC, CBA, BCA... are considered as the same triangle.
* All points are unique: they have different names and coordinates.
* n <= 100
