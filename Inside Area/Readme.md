# Puzzle
**Inside Area** https://www.codingame.com/contribute/view/116307401f258c5fc3eefb91cddc3f6549d04e

# Goal
A robot is navigating a 2D plane, following a set of movement instructions.  
The following symbols are used to indicate the movement directions:  
* ^ : Move up
* v : Move down
* \> : Move right
* < : Move left

Each instruction consists of a direction and an integer step indicating the number of units to move in that direction. For example, "> 5" means the robot will move 5 units to the right.

After executing all instructions, the robot returns to its starting point, creating a closed, non-self-intersecting polygon.

Example:
```
4
> 3
v 2
< 3
^ 2
```

The robot will make a path looks like:  
```
......
.####.
.#..#.
.####.
......
```


We want to know the area enclosed by the robot's path, including the path.  
It looks like:  
```
......
.####.
.####.
.####.
......
```

So, the area is 12.

Can you determine the enclosed area based on the given set of instructions?

# Input
* Line 1: number of instructions n
* Following n lines: one instruction in each row. formatted as direction step, meaning that the robot should move step units in direction

# Output
* Line 1: area inside the path, including the path.
