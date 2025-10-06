# Pizzle
**Unflood The World** https://www.codingame.com/training/expert/unflood-the-world

# Goal
A rectangular map is made of squares, each with a specific height.  
When it rains, the water falls evenly on all squares.  

The water flows down from any square to an adjacent lower one. The water also flows freely between adjacent squares of equal height.   
If a square is surrounded by higher squares, the water just accumulates there.

You are allowed to build drains in some squares.  
When a square has a drain, all the water that would accumulate on it will leak out instead.

What is the minimum number of drains that have to be built to leak out all the rain water?

NOTE: Adjacency is horizontal or vertical. Squares that touch diagonally through a corner aren't adjacent.  
NOTE: The water can never flow outside the map. You can consider it bounded by walls of infinite height.  

# Input
* First line: integers N and M - width and height of map
* Next M lines: N space separated integers between 1 and 10000 - height of each square

# Output
* A single integer - number of drains to be built.

# Constraints
* 1 <= N, M <= 100
