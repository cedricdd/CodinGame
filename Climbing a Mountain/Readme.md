# Puzzle
**Climbing a Mountain** https://www.codingame.com/contribute/view/1324448c334cca12b4b20bafee87be35594a6b

# Goal
You are given a rectangular grid with dimensions width w and height h. Each cell in the grid contains an integer value representing the height of the mountain at that point. You want to climb from one point to another on this mountain.

You have a fixed step size s, which represents the maximum difference in height you can ascend in a single step. If the height difference between your current cell and the next cell is greater than s, you cannot move there in one step. Note: You can move down an infinite amount (but still within the constraints. What this means is that:  
* Let's say that s is 8.
* You can move from 54 to 62, but not 76 to 84.
* But you can move from 978 to -987 (but not the other way around).

Your task is to determine the minimum number of steps required to reach the highest point of the mountain from a given starting point, assuming you can move to any adjacent cell (up, down, left, right) if the height difference constraint is satisfied.

If the highest point is unreachable given your step size, output Not Possible.

Note: The top-left corner of the grid is (0, 0).  
Note: There may be multiple locations tied for the highest point, and reaching any one of them counts.  

# Input
* Line 1: Two space-separated integers - w and h - representing the width and height of the grid.
* Next h lines: w space-separated integers representing the heights of the mountain in a line of the grid.
* Next line: Two space separated integers - x and y - representing the starting coordinates.
* Next line: An integer s - the step size.

# Output
* Line 1: The minimum number of steps required to reach the highest point of the mountain starting at (x, y) or Not possible if the highest point is unreachable.

# Constraints
* 2 ≤ w,h ≤ 15
* 0 ≤ x < w
* 0 ≤ y < h
* 1 ≤ s ≤ 100
* -1,000 ≤ The integers in the grid ≤ 1,000
