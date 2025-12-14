# Puzzle
**The Mystic Rectangle** https://www.codingame.com/training/easy/the-mystic-rectangle

# Goal
Ataria lives on a toroidal map known as the Mystic Rectangle, where opposite edges of the map are connected.   
Crossing an edge teleports her to the opposite side. Ataria can move in any of the four cardinal directions or along the four diagonals of 45 degrees.  

Given Ataria's coordinates and the coordinates of the goal, find the fastest time for her to reach the goal, assuming no obstacles.  

Moving East or West ±1 unit in x takes 0.3 seconds.  
Moving North or South ±1 unit in y takes 0.4 seconds.  
It takes 0.5 seconds to move diagonally, 1 unit East/West plus 1 unit North/South.  

After travelling for 1 minute in any single cardinal direction (that is, 200 units East/West, or 150 units North/South), she ends up returning to the same place.

Example  
Suppose Ataria starts near the top of the map and travels diagonally 15 units NorthEast and then straight 5 units due North.   
In doing so, she wraps around to the bottom of the map, arriving at the goal. Then at 9.5 seconds, this direct route makes the best time to the goal.  

# Input
* Line 1: Two space separated integers x and y for the current position
* Line 2: Two space separated integers u and v for the location of the goal

# Output
* Line 1: The decimal time to the goal in seconds, with precision of tenths

# Constraints
* 0 ≤ x, u < 200
* 0 ≤ y, v < 150
