# Puzzle
**N-dimensional maze** https://www.codingame.com/contribute/view/1258448ac16376b47315eb1baa28acc378862b

# Goal
While travelling with your spacetime machine, you accidentally discover new dimensions to explore. The n-dimensional space is represented by an n-dimensional grid of cells. You can move to any free neighboring cell, in any direction. Two cells are neighbors if their coordinates differ by one, in exactly one direction. For example, (1, 4, 6, 2, 0) and (1, 4, 6, 1, 0) are neighbors. A cell has 2 neighbors in 1D, 4 in 2D, 6 in 3D, and 2n in nD.

You are given the size of the space in each dimension and a list of obstacles, each defined by two opposite corners of an axis-aligned n-dimensional hyperrectangle. For example, with n=4, the obstacle going from (3, 1, 6, 4) to (3, 2, 8, 4) includes the cells (3, 1, 6, 4), (3, 1, 7, 4), (3, 1, 8, 4), (3, 2, 6, 4), (3, 2, 7, 4) and (3, 2, 8, 4). Obstacles may intersect each other (the intersections remain obstacles).

Given your starting position and your destination, output the total length of the shortest path from one point to the other. If no path exists between the two points, output NO PATH.

Example :
```
3
3,3,3
1,2,0
2,0,0
3
0,1,0 0,1,0
0,1,2 0,1,2
1,1,0 2,1,2
```

Let's represent this maze (. is a free space, # is an obstacle, S and D are your start position and destination). It is a cube of size 3. We can see it as a three-floor maze (z=0 to z=2), with a wall at position x=1, with only one free cell (1,0,1).
```
   z=0   z=1   z=2

   x->   x->   x->

y  ..D   ...   ...
|  ###   .##   ###
V  .S.   ...   ...
```

One of the shortest possible paths is shown below, with each step numbered from 0 (start) to 7 (destination).
```
   z=0   z=1   z=2

   x->   x->   x->

y  ..7   456   ...
|  ###   3##   ###
V  10.   2..   ...
```

Therefore, the output should be 7.

# Input
* Line 1: An integer n, the number of dimensions of the maze.
* Line 2: n comma-separated integers, the size of the maze in every direction.
* Line 3: n comma-separated integers, the coordinates of your starting position.
* Line 4: n comma-separated integers, the coordinates of your destination.
* Line 5: An integer b, the number of obstacles.
* Next b lines: 2 space-separated sequences of n comma-separated integers, representing two opposite corners of an obstacle. Every coordinate of the first corner is less than or equal to its corresponding counterpart in the second corner.

# Output
* One line: An integer, the length of the shortest possible path from your position to your destination, or NO PATH if no such path exists.

# Constraints
* 1 ≤ n ≤ 8
* 0 ≤ b ≤ 100
* 0 ≤ All coordinates ≤ 20
* Valid coordinate values in each dimension range from 0 to size of that dimension - 1.
* Starting position and destination are not located inside of obstacles.
