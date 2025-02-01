# Puzzle
**Rectangle Partition** https://www.codingame.com/training/easy/rectangle-partition

# Goal
There is a rectangle of given width w and height h.  
On the width side, you are given a list of measurements.  
On the height side, you are given another list of measurements.  

Draw perpendicular lines from the measurements to partition the rectangle into smaller rectangles.  

In all sub-rectangles (include the combinations of smaller rectangles), how many of them are squares?  

Example
```
w = 10
h = 5
measurements on x-axis: 2, 5
measurements on y-axis: 3

   ___2______5__________ 
  |   |      |          |
  |   |      |          |
 3|___|______|__________|
  |   |      |          |
  |___|______|__________|
```

Number of squares in sub-rectangles = 4 (one 2x2, one 3x3, two 5x5)

# Input
* Line 1: Integers w h countX countY, separated by space
* Line 2: list of measurements on the width side, countX integers separated by space, sorted in asc order
* Line 3: list of measurements on the height side, countY integers separated by space, sorted in asc order

# Output
* Line 1: the number of squares in sub-rectangles created by the added lines

# Constraints
* 1 ≤ w, h ≤ 20,000
* 1 ≤ number of measurements on each axis ≤ 500
