# Puzzle
**Vectors in variables dimensions** https://www.codingame.com/training/easy/vectors-in-variables-dimensions

# Goal
You are a space-time traveller who travel across universes.  
You want to know where you can go, so you got yourself a list of anchors' coordinates (as you travel not only in space there can be more than 3 components for each point).   
The goal of this exercise is to output the shortest (non zero) and the longest vectors you can form from your list.  
As in 2D: distance in higher dimensions is calculated as follow:  
For two points A(a1, a2, ..., an) and B(b1, b2, ..., bn), d = √((a1-b1)²+(a2-b2)²+...+(an-bn)²)  

# Input
* Line 1: An integer D for the number of dimensions your points will be in.
* Line 2: An integer N for the number of points you receive.
* N next lines: One point per line, written like A(0,1,2), every component is integer.

# Output
* Line 1: The shortest non-zero vector, if it is the one between A and B, it will be AB(xb-xa,yb-xa,zb-za), the first point should be the one that appears first in the list
* Line 2: The longest vector, written the same way.

# Constraints
* 1 ≤ D ≤ 10
* 2 ≤ N ≤ 100
* -20 ≤ each component ≤ 20
* It is guaranteed that there is only one shortest and one longest in each case.
