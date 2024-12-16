# Puzzle
**Jump Point Search - Runtime** https://www.codingame.com/training/hard/jump-point-search---runtime

# Goal
For a given map, the goal is to compute the optimal path given the table with the precomputed jump point distances, according to the algorithm from the article.

Jump Point Search (JPS) is an A* optimization dedicated to uniform-cost grid maps.  
Its two main improvements are using cardinal path ordering - responsible for pruning redundant optimal paths of the same cost; and jump points - special direction-changing nodes placed in the open list to reduce its size.  
JPS+ is an enhanced version of JPS, introducing static map analysis to further improve search speed.

The goal of this series of puzzles is to implement JPS+ according to the description from Steve Rabin, Fernando Silva.  
"An Extreme A* Speed Optimization for Static Uniform Cost Grids", Game AI Pro 2: Collected Wisdom of Game AI Professionals, pp. 131-143, 2015.  

Here, your task is to implement the runtime phase. For a given rectangle map containing open tiles and walls, start and goal tiles, and precomputed distances to the closest wall / jump point for every open tile in each of the octile directions, you have to simulate the pathfinding procedure.

*Detailed rules*  
Given a grid of the size width×height, with 0 0 being the upper left corner in column row notation.  
The grid contains only open (passable) tiles and wall tiles (impassable).  
There are eight possible directions of movement: N NE E SE S SW W NW, where N means "up", and E "right".  
Moving diagonally is possible only when tiles of both related cardinal directions are passable.  
For example, going NE requires both N and E neighboring tiles to be open.  
The result of the preprocessing phase is encoded as a set of passable tiles, each formatted as column row N NE E SE S SW W NW, where column row contain the tile coordinates, and the remaining numbers are distances in the corresponding directions.  
For example, 2 0 3 -2 1 4 2 -1 -1 4 means that for the tile of column 2 and row 0 going north there is a jump point 3 tiles away, going northeast there is a wall 2 tiles away, etc.  
The JPS+ runtime procedure should work as described in the section 14.7 of the cited publication.  
You need to implement the open list with a priority queue.  
The heuristic function in use for the A* part shall be the octile distance:  
For two points (x1,y1) and (x2,y2), the octile distance is given by dx + dy + (√2 - 2) . min(dx,dy) where dx = |x2-x1| and dy = |y2-y1|.  
For each node popped from the open list, your goal is to send one line, containing information about this node.  
Each line should be formatted as nodeColumn nodeRow parentColumn parentRow givenCost, where nodeColumn nodeRow contains the coordinates of the current node, parentColumn parentRow contain the coordinates of the node's parent, and givenCost is the cost of traversing from the start to the node.  
When the algorithm finds that path does not exist (open list is empty), you should send NO PATH.  

*Victory Conditions*  
All given nodes are correct.  
If path does not exist, it is detected in the right time.  

*Loss Conditions*  
Incorrect node information is sent.  
No information about nonexisting path is sent.  
Given answer is not properly formatted.  
Response time exceeds the time limit.   

# Input
* First line: two space-separated integers, width height, for the size of the map, 0 0 being the upper left corner.
* Second line: four space-separated integers, startColumn startRow goalColumn goalRow, with the coordinates of the start tile and goal tile accordingly.
* Third line: an integer open, the number of open tiles on the map.
* Following open lines: one line for each empty tile of the map containing space-separated integer values column row N NE E SE S SW W NW, where column row indicates the position of the tile, and the remaining eight values are distances in corresponding directions to the closest jump point (positive number) or wall (otherwise). The ordering of the tiles is arbitrary.

# Output for the first turn
* Initial node representing the start tile: a single line containing startColumn startRow -1 -1 0.00.

# Output for the following turns
* Information about the node popped from the open list containing nodeColumn nodeRow parentColumn parentRow givenCost, 
* where nodeColumn nodeRow contain the coordinates of the current node, parentColumn parentRow contain the coordinates of the node's parent, and givenCost is the cost of traversing from the start to the node.
* Information that the path does not exist, the string NO PATH. It has to be sent on the turn that has an empty open list.

# Constraints
* 3 ≤ width ≤ 20
* 3 ≤ height ≤ 20
* Response time for first turn ≤ 1s
* Response time for one turn ≤ 50ms
