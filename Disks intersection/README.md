# Puzzle
**Disks intersection** https://www.codingame.com/training/hard/disks-intersection

# Goal
Given centers and radius of two disks, you must determine their intersection area, rounded at a precision of 10^-2.  
So if you think the area is 42.3371337, you must output 42.34 and if your answer is 41.78954719, you must print 41.79.  

If these disks do not intersect, or intersect in one point, then the area is 0.00 .

# Input
* Line 1 : x1 y1 r1. x1 and y1 determine the position of the center of the first disk, and r1 its radius
* Line 2 : x2 y2 r2. x2 and y2 determine the position of the center of the second disk, and r2 its radius

# Output
* The intersection area of the disks, rounded at a precision of 10^-2.

# Constraints
* -1000 < x1,y1,x2,y2 < 1000
* 1 ⩽ r1,r2 < 1000
