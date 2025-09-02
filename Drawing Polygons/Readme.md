# Puzzle
**Drawing Polygons** https://www.codingame.com/training/hard/breakout

# Goal
You have to print the direction (CLOCKWISE or COUNTERCLOCKWISE) used to construct a polygon defined by a specified sequence of points.

Consider that the points represent the vertices of an arbitrary polygon, and you can draw the polygon if you take the points pairwise, in the order they are given. So, every two consecutive points form an edge, and the last edge is formed by the last and the first points.

Example 1
```
P(1) => x=6, y=5
P(2) => x=11, y=5
P(3) => x=11, y=2
P(4) => x=3, y=2

│ · · · · · · · · · · · · ·
│ · · · · · 1 · · · · 2 · ·
│ · · · · · · · · · · · · ·
│ · · · · · · · · · · · · ·
│ · · 4 · · · · · · · 3 · ·
│ · · · · · · · · · · · · ·
┼───────────────────────────
```

The polygon is in the CLOCKWISE direction.

Example 2
```
P(1) => x=6, y=5
P(2) => x=11, y=5
P(3) => x=11, y=2
P(4) => x=16, y=7


│ · · · · · · · · · · · · · · · · · ·
│ · · · · · · · · · · · · · · · 4 · ·
│ · · · · · · · · · · · · · · · · · ·
│ · · · · · 1 · · · · 2 · · · · · · ·
│ · · · · · · · · · · · · · · · · · ·
│ · · · · · · · · · · · · · · · · · ·
│ · · · · · · · · · · 3 · · · · · · ·
│ · · · · · · · · · · · · · · · · · ·
┼─────────────────────────────────────
```

The polygon is in the COUNTERCLOCKWISE direction.

# Input
* Line 1: an integer N indicating the number of points in the polygon
* Next N lines: a pair of space-separated integers X Y giving the location of a point

# Output
* One line: CLOCKWISE or COUNTERCLOCKWISE

# Constraints
* N ranges from 4 to 20
* X and Y range from 0 to 20
