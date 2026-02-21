# Puzzle
**Windmill problem** https://www.codingame.com/training/medium/windmill-problem

# Goal
*Windmill Process*

Given a finite plane S having at least three points. The windmill process can be define as follow:
- Start with a line ℓ going through a point P ∈ S
- Rotate ℓ clockwise around the pivot P until the line hits another point Q of S.
- The point Q now takes over as the new pivot.

This process continues until there is N changes of pivot.

*Objectives*

Given:
- all points of S (there will never be three collinear points in S)
- the starting pivot P
- the number N of pivot changes

Your objective is to make a simulation of this process. You should output :
- The index of the pivot
- For each point, the number of times it has been a pivot

*Definition of S*  
S is a plane of 800 x 600  
Position (X, Y) = (0, 0) is at the bottom left of S  
The line ℓ will always start horizontally  
The line ℓ will never starts aligned with another point  
All point coordinates are integers.  

*Example*

Let's assume we have K=3 points (x, y) at:
- #0: (200,200)
- #1: (400,300)
- #2: (400,100)
- and N == 3

The starting point P is #1 so the line starts horizontally at 400, 300.  
The line turns Clockwise by 90 degrees and hits the point 2. It becomes the new pivot (1st time).  
The line continues to turn and hits the point 0 after around 120 degrees. It becomes the new pivot (1st time).  
The line turns again around 120 degrees and hits point 1 which becomes the pivot (2nd time).  

As a result after 3 changes of pivot the result is:
```
1
1
2
1
```

The first 1 is for the pivot index and the rest is the number of time each point was a pivot.

# Input
* Line 1: Number of points on S, called K
* Line 2: Number of pivot changes, called N
* Line 3: Index P of the starting pivot (0-indexed)
* Next K lines: Two integers for the position of each point X, Y

# Output
* Line 1: The index of the current pivot
* K lines: One integer for the number of times each point was a pivot

# Constraints
* 2 < K ≤ 30
* 0 < N ≤ 10^12
* 0 ≤ X ≤ 800
* 0 ≤ Y ≤ 600
* The line ℓ will never starts aligned with another point
