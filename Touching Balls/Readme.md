# Puzzle
**Touching Balls** https://www.codingame.com/contribute/view/1207959fd5bf567cc4ed52db17543f0fd27057

# Goal
You are given N non-overlapping spheres, each centered at (x,y,z) with radiusr. In the same order as they are given, expand the radius of each sphere until it touches any of the other spheres.

# Input
* Line 1: The Number of spheres
* Next N lines: x y z r for each sphere, space separated

# Output
* The sum of r^3 for all the expanded spheres, rounded to the nearest integer.

# Constraints
* 2 ≤ N ≤ 100
* 0 ≤ x,y,z ≤ 100
* 0 < r ≤ 100
