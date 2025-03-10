# Puzzle
**Pathfinding with Landmarks** https://www.codingame.com/contribute/view/100269a99b3b42fe33f40db2048925d003cefa

# Goal
Your goal is to place on a given map the available landmarks to improve the efficiency of pathfinding on this map.

# Rules
The ALT (A* search, landmarks, triangle inequality) heuristic is a method to improve A*-based pathfinding efficiency by precomputing distances to specific points of the map (so-called landmarks). The idea was introduced by Andrew V. Goldberg, Chris Harrelson in "Computing the shortest path: A* search meets graph theory", SODA, Vol. 5, pp. 156-165, 2005. (extended version linked).

Briefly, the idea works as follows.

To obtain a bound on the distance between two points a and b, we could use a third point c, assuming we would know distances between a and c, and b and c. Then, given the triangle inequality, we know that the missing edge needs to be at least as long as the absolute of the difference between the known edges.

In the A* algorithm, we use a heuristic approximation of the distance from the given node to the goal node. In ALT this heuristic is based on landmarks: carefully chosen nodes, for which we precompute distances to all other nodes in the map. Then, during the runtime of A* search, to estimate the distance between two nodes, we can obtain bounds from each of our landmarks and then choose the tightest one (i.e., containing the largest estimation). You can also read more about the method here.

*Detailed rules:*
* Given a grid map of the size width×height, with 0 0 being the upper left corner in column row notation.
* The map contains only open (passable) tiles and wall (impassable) tiles, and it will always be surrounded by the wall tiles.
* There are eight possible directions of movement: via cardinal directions and using diagonals. The cost of a step in cardinal direction is 1. The cost of a step in diagonal direction is √2.
* For a given map and number of available landmarks, you need to provide coordinates to place the landmarks (inside the map, excluding tiles with walls).
* The efficiency of the search is defined as the number of nodes on the shortest path divided by the number of nodes scanned by the algorithm (so-called closed nodes).
* For each map, provided landmark locations will be tested by using multiple pairs of start and goal nodes. (A path between these nodes will always exist.) Maps are based on the benchmarks from movingai.com.
* To pass a given map, the average efficiency of the A* search using your landmark locations as a heuristic needs to be high enough. (Each map will have its own requirements.)

*Victory Conditions*  
* The average efficiency of the landmark-based A* search is at least as high as the required efficiency. 

*Loss Conditions*  
* The placement of the landmarks is incorrect (outside of the map or on the wall).
* The average efficiency is below the given requirement.
* The answer is not properly formatted.
* Response time exceeds the time limit. 

# Input
* First line: two space-separated numbers: integer landmarksNum and floating point efficiency, where landmarksNum is the number of landmarks you are required to place on the map, and efficiency is the required average efficiency to past given test.
* Second line: two space-separated integers, width height, for the size of the map, 0 0 being the upper left corner.
* Following height lines: a string of length width, containing a row of the map (top to bottom). Passable terrain is encoded as ., and impassable wall tiles are encoded as #.

# Output
* landmarksNum lines, each containing coordinates of the landmark given as two space-separated integers: column row.

# Constraints
* 10 ≤ width, height ≤ 240
* 2 ≤ landmarksNum ≤ 20
* Response time for the first (and only) turn ≤ 20s
