# Puzzle
**Lines Intersections** https://www.codingame.com/training/easy/lines-intersections

# Goal
You are given a set of infinite lines in a 2D (x-y) plane.

Your task is to find all the intersection points of these lines.

# Input
* First line: an integer N — the number of infinite lines
* Next N lines: four space-separated integers x1 y1 x2 y2 describing one infinite line passing through points (x1, y1) and (x2, y2)

# Output
* First line: an integer K — the number of intersection points.
* Next K lines: two space-separated real numbers x y representing the coordinates of each intersection point.

Output the points in ascending order, sorted by x-coordinate and then by y-coordinate.   
Each coordinate must be rounded and printed to 3 decimal places.  
When multiple lines intersect in the same point, output it only once.  

NOTES:  
In geometry, two coincident lines have infinite number of intersection points.  
However, for the purpose of this puzzle, coincident lines are treated as parallel and no intersection point should be output.  

# Constraints
* 0 ≤ N ≤ 10
* 0 ≤ K ≤ 45
* −100 ≤ x1, y1, x2, y2 ≤ 100
* For each given line, (x1, y1) ≠ (x2, y2).
