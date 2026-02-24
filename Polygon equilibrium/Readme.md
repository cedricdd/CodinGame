# Puzzle
**Polygon equilibrium** https://www.codingame.com/training/medium/polygon-equilibrium

# Goal
We consider a solid planar polygon with uniform density, placed upright on a horizontal ground line. The polygon can be rotated freely and then lowered until it touches the ground.

When the polygon is resting on the ground, it may touch the ground at one or more of its vertices. A supporting segment is defined as a pair of vertices of the polygon such that, in some rotation of the polygon:
* Both vertices lie on the ground at the same time, and
* No other part of the polygon goes below the ground in that position.
* Any other part of the polygon touching the ground (edge, vertex) is located between the 2 vertices.

When more than two vertices can touch the ground at the same time, the corresponding supporting segment is defined by the leftmost and rightmost vertices.

A static equilibrium occurs when, in addition to being a supporting segment, the polygon remains at rest on that segment without tipping to either side. This happens when the center of mass of the polygon lies horizontally between the two vertices touching the ground (both vertices included).

Your task is to:
* Count how many distinct pairs of vertices form supporting segments.
* Count how many of these supporting segments correspond to static equilibria.

# Input
* Line 1: an integer n, the number of vertices.
* Next n lines: two space-separated integers x and y, the coordinates of one vertex of the polygon. The vertices are given in order.

# Output
* Line 1: an integer, the number of supporting segments.
* Line 2: an integer, the number of static equilibria.

# Constraints
* 3 ≤ n ≤ 100
* 0 ≤ x, y ≤ 1000
* The polygon is non-self-intersecting.
* The polygon is non-degenerate.
