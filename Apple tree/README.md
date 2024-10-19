# Puzzle
**Apple tree** https://www.codingame.com/training/hard/apple-tree

# Goal
There are N apples on the tree. Every apple is a sphere with position (x, y, z) and radius r.  
Then the i-th apple begins to fall straight down and can collide with others.   
When static apple gets hit by the falling one it begins to fall too, and the falling apple continues to fall straight down.  
Your task is to determine how many apples will remain on the tree.  

"Down" direction is vector (0, 0, -1), i.e. apple with position (0,0,10) is higher than (0,0,5)

# Input
* Line 1 Two integers N and i – the number of apples and index of the falling apple
* Next N lines Four space-separated integers X, Y, Z and R – position and radius of the apple

# Output
* A single integer – number of remaining apples

# Constraints
* 1 ≤ N < 100
* 0 ≤ i < N
* -1000000 ≤ x, y, z ≤ 1000000
* 1 ≤ r < 1000000
