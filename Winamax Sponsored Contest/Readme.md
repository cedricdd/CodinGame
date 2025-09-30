# Puzzle
**Winamax Sponsored Contest** https://www.codingame.com/training/hard/winamax-sponsored-contest

# Rules
In this puzzle, you are given a grid representing a golf course.  
On each course is a certain amount of balls and an equal amount of holes. The objective is to find the route for each ball to a different hole without their paths ever crossing.  

Your program must output the unique solution for each course.  

A course has a given number of columns and rows. Each cell is represented by a character.  
The cells can be:  
* A dot . for an empty cell.
* A positive integer between 1 and 9 for a ball. The value indicates the ball's shot count.
* The letter X for a water hazard.
* The letter H for a hole.

Balls can be hit multiple times across the grid, as many times as their shot count.  
Your program must output a grid of equal width and height, containing arrows indicating how the balls must be hit.  
An arrow is represented by a sequence of cells containing a direction.  
The four directions are represented by the characters v, <, > and ^ (respectively down, left, right and up).  

To show the movement of a ball, an arrow must start in the cell where the ball begins and must stop right before the cell in which the ball lands.  
You need only output arrows in your solution, the rest of the grid should be respresented with dot . characters.  

A ball moves across as many cells as its shot count the first time it moves, vertically or horizontally. The next move becomes one shorter, it decreases the number of cells to pass by 1. The direction of movement may change after a move. When the next movement becomes 0, or the ball stops at a hole cell, the ball may not be moved any further.

Arrows cannot cross balls, holes, or other arrows.

Each ball must end in a hole. Holes may receive no more than 1 ball.

A ball cannot leave the grid, and cannot stop in a water hazard. It can however go over water hazards.

# Input
* Line 1: Two space separated integers width and height representing the size of the grid.
* Next height lines: One row of the grid containing width characters.

# Output
* All height rows of the solution grid, containing dots . for untouched cells or the characters v, <, >, ^ for arrows.

# Constraints
* 0 < width ≤ 1000
* 0 < height ≤ 1000
