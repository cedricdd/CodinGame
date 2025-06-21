# Puzzle
**The Lord of the Annuli** https://www.codingame.com/training/medium/the-lord-of-the-annuli

# Goal
You need to draw a ring (or annulus) using ASCII characters in a rectangular area of width width and height height. The ring is defined by a center point (cx, cy) and two radii, the outer radius ro and the inner radius ri. The coordinates are relative to the upper left point of the rectangle, which represents the point (0,0). If ri=0, then the ring becomes a disc.

Note: cx, cy, ro and ri need not be whole numbers.

For each character in the rectangle, each of which is assumed to be half a unit wide and one unit tall (to ensure a proper aspect ratio), determine the coverage of the ring at that position, which is the portion of the area of the character covered by the ring. Map this coverage from 0% to 100% to the character to use, using the following rules:

From 0% (inclusive) to 10% (exclusive): use a space (" ").  
From 10% (inclusive) to 20% (exclusive): use a dot (.).  
From 20% (inclusive) to 30% (exclusive): use a colon (:).  
From 30% (inclusive) to 40% (exclusive): use a dash (-).  
From 40% (inclusive) to 50% (exclusive): use an equals sign (=).  
From 50% (inclusive) to 60% (exclusive): use a plus sign (+).  
From 60% (inclusive) to 70% (exclusive): use an asterisk (*).  
From 70% (inclusive) to 80% (exclusive): use a hash sign (#).  
From 80% (inclusive) to 90% (exclusive): use a percent sign (%).  
90% (inclusive) or more: use an at sign (@).  

The ring's coverage for each character cannot be calculated using closed-form geometry and must therefore be determined via supersampling. Supersampling tests a regular grid of samples*samples points within the area of each character and determines the ratio of points inside the ring divided by the total number of points, which is the coverage for that area. The supersampling points for the character in column x and row y are located at (x + (i+0.5)/samples, y + (j+0.5)/samples) for i and j from 0 to samples-1. For example, if samples=2, the four supersampling points are (x+0.25, y+0.25), (x+0.75, y+0.25), (x+0.25, y+0.75), (x+0.75, y+0.75).

A point (x, y) is on the ring if and only if ri² <= (x-cx)² + (y-cy)² <= ro². A point on the edge of the ring is also counted as on the ring.

You need to draw a simple frame around the rectangle, consisting of - (for horizontal lines), | (for vertical lines) and + (for the 4 corners). The frame does not count towards the drawing area of width and height characters and does not influence the coordinate system. The top-left character of the drawing area is still row 0, column 0.

Show your skills by drawing the ring!

# Input
* Line 1: width height cx cy ro ri samples
    * width: The width of the rectangle in characters (excluding the frame around it)
    * height: The height of the rectangle in characters (excluding the frame around it)
    * cx: The x-position of the center of the ring
    * cy: The y-position of the center of the ring
    * ro: The outer radius
    * ri: The inner radius
    * samples: The number of samples per character per dimension (samples² per character)

# Output
* height + 2 lines: The rows of the ASCII art, each width+2 characters long, including the frame around it

# Constraints
* 0 < width <= 40, width is an integer
* 0 < height <= 20, height is an integer
* -500 <= cx<= 500, cx is a float
* -500 <= cy<= 500, cy is a float
* 0 <= ri < ro <= 340, ri and ro are floats
* 1 <= samples <= 25, samples is an integer
