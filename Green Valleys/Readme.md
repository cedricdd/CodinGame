# Puzzle
**Green Valleys** https://www.codingame.com/training/medium/green-valleys

# Goal
We are in a country surrounded by snowy mountains, and just a small amount of green valleys.  
The snow line is at H meters, and above that, everything is white in snow. At that height and below, it is a fruitful paradise.

You receive a square shaped map of an area.  
Every data represents One square kilometer in size.  
Fields are represented by integer values separated by spaces on a map, which integer means the average height of that point above sea level.  
Up to height H, the place is green, every tile under (or equal) this height is part of a valley, and every tile above it is white in snow, and part of the mountains.  

A valley is one or multiple green places. If a green place is either horizontally or vertically next to another green place, they belong to the same valley.  
Green places that are only touching diagonally are not in the same valley.  
If the valley is touching the border of the map we receive, it is considered ending at the edge, so the size of it is the size we can count.   
In other words: The whole map is covered by snowy mountains, on the outside.  

Your job is, to tell the deepest point of the largest valley (in surface area) on the map.

If there are no valleys on the map, the answer is 0 (zero).  
If there are multiple valleys with the same size, then the answer is the deepest point overall from the largest valleys.

# Input
* Line 1: An integer H representing the height of the snow line (including this value, and under).
* Line 2: An integer N for the length of one side of the map.
* Next N lines: N number of integers (as h), separated by one space.

# Output
* Line 1 : The deepest point of the largest valley.

# Constraints
* 0 < H < 2000
* 0 < N < 21
* 0 < h < 2000
