# Puzzle
**Bouncing Simulator** https://www.codingame.com/contribute/view/109113f1e9865b29bb3ed0fa9d589883fc730b

# Goal
Your aim is to simulate a ball bouncing in a closed container of width w and height h (excluding the area covered by the boundary) after n number of hits. The ASCII representation of the box has a boundary drawn by hashes (#)  
The ball starts from the top-left of the container and moves south-east, changing its direction depending on the surface it hits.  
The path of the ball is to be marked by numbers, denoting the number of times the ball has passed through that point.  

# Input
* Line 1: The width: w
* Line 2: The height: h
* Line 3: The number of hits: n

# Output
* The ASCII representation of the box, including the path of the ball

# Constraints
* No variable can exceed 100.
* There is no testcase which has a ball passing through a cell of the grid more than 9 times.
