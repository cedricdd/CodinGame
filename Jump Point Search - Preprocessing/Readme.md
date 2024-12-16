# Puzzle
**Jump Point Search - Preprocessing** https://www.codingame.com/training/hard/jump-point-search---preprocessing

This exercise requires implementing the preprocessing phase of the improved Jump Point Search algorithm, based on Steve Rabin, Fernando Silva.  
"An Extreme A* Speed Optimization for Static Uniform Cost Grids", Game AI Pro 2: Collected Wisdom of Game AI Professionals, pp. 131-143, 2015.  
http://www.gameaipro.com/GameAIPro2/GameAIPro2_Chapter14_JPS_Plus_An_Extreme_A_Star_Speed_Optimization_for_Static_Uniform_Cost_Grids.pdf

# Goal

For a given map, the goal is to compute the table with the correct wall / jump point distances, according to the algorithm from the article.

Jump Point Search (JPS) is an A* optimization dedicated to uniform-cost grid maps.  
Its two main improvements are using cardinal path ordering - responsible for pruning redundant optimal paths of the same cost; and jump points - special direction-changing nodes placed in the open list to reduce its size.  
JPS+ is an enhanced version of JPS, introducing static map analysis to further improve search speed.

The goal of this series of puzzles is to implement JPS+ according to the description from Steve Rabin, Fernando Silva.  
"An Extreme A* Speed Optimization for Static Uniform Cost Grids", Game AI Pro 2: Collected Wisdom of Game AI Professionals, pp. 131-143, 2015. 

Here, your task is to implement the preprocessing phase. For a given rectangle map containing open tiles and walls, you have to compute distances to the closest wall / jump point for every open tile in each of the octile directions.

*Detailed rules*  
Given a grid of the size width×height, with 0 0 being the upper left corner in column row notation.  
The grid contains only open (passable) tiles, encoded as ., and wall tiles (impassable), encoded as #.  
There are eight possible directions of movement: N NE E SE S SW W NW, where N means "up", and E "right".  
Moving diagonally is possible only when tiles of both related cardinal directions are passable.  
For example, going NE requires both N and E neighboring tiles to be open.  
The JPS+ preprocessing procedure should work as described in the section 14.6 of the cited publication.  
For each of the open tiles, your goal is to send one line, containing computed distances to the closest wall / jump point in each of the eight directions.  
Each line should be formatted as column row N NE E SE S SW W NW, where column row contains the tile coordinates, and the remaining numbers are distances in the corresponding directions.  
For example, 2 0 3 -2 1 4 2 -1 -1 4 means that for the tile of column 2 and row 0 going north there is a jump point 3 tiles away, going northeast there is a wall 2 tiles away, etc.  
Ordering of the lines is irrelevant as long as all open nodes are assigned all their corresponding distance values.  

*Victory Conditions*  
All given distance values are correct. 

*Loss Conditions*  
At least one of the given distance values is incorrect.  
Given answer is not properly formatted.  
Response time exceeds the time limit.  


# Input
* First line: two space-separated integers, width height, for the size of the map, 0 0 being the upper left corner.
* Following height lines: a string of length width, containing a row of the map (top to bottom). 
* Impassable wall tiles are encoded as #, and passable terrain is encoded as .

# Output
* One line for each empty tile of the map containing space-separated integer values column row N NE E SE S SW W NW, where column row indicates the position of the tile, and the remaining eight values are distances in corresponding directions to the closest jump point (positive number) or wall (otherwise).  
* The ordering of the tiles is arbitrary.

# Constraints
* 3 ≤ width ≤ 20
* 3 ≤ height ≤ 20
* Response time ≤ 1s
