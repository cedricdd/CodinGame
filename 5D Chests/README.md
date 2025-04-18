# Puzzle
** 5D Chests** https://www.codingame.com/training/medium/5d-chests

# Goal
Pirx the Pilot is flying his spaceship through hyperspace in search of gold.   
Given a 5D realm with all dimensions ranging from 1 to N, each location (x,y,z,w,v) is either a chest of gold (1) or a barrier (0) as determined by the function:
```
f(x,y,z,w,v) = isprime(1 + mod(x*y*z*w*v,C))
```
The barriers form rooms in hyperspace (Pirx can only move along the five dimensions, no diagonals). Help Pirx search every room and find all the gold.

# Input
* First line: The size N of each dimension.
* Second line: The constant C for terrain generation.

# Output
* First line: The total number of gold chests.
* Second line: The number of rooms that contain at least one chest.
* Third line: The largest number of gold chests in one room.

# Constraints
* 3 ≤ N ≤ 20
* 2 ≤ C ≤ 10,000
