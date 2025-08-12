# Puzzle
**City Lights Part 2** https://www.codingame.com/training/easy/city-lights-part-2

# Goal
Great news! Bob from Bobville discovered the 4th Dimension and found a way to move there!  
Bobville can be displayed as a 3D grid with length l, width w, and depth d, viewed from the sky.  
The grid from both the input and output is a 2D grid with length (horizontally) and width (vertically) repeated depth times, with a line break between each 2D grid.  
So length = 3, width = 4, depth = 2 would look like this:  
```
###
###
###
###

###
###
###
###
```

Each cell from the 3D grid contains either a . or a single character representing a light source radius:  
- 1 to 9 represent radius 1 to 9
- A to Z represent radius 10 to 35 (A=10, B=11, ..., Z=35)

If lit, the brightness from that source on the cell is: ```brightness = radius - d```

Where d is the (3D) Euclidean distance from the source cell center to the target cell center, rounded to the nearest integer.

If multiple sources light a cell, add their brightness values.  
If no source lights a cell, its brightness is 0.  
If the brightness calculated using the formula results in a negative value, it should be treated as 0.  

Output the full grid of Bobville showing the brightness of each cell, using:
- 0–9 for brightness 0–9
- A–Z for brightness 10–35

Note: For a value above Z (like 36), it is still Z.  
Note: The brightness applies uniformly to a whole cell.  

# Input
* Line 1: An integer l representing the length of the grid.
* Line 2: An integer w representing the width of the grid.
* Line 3: An integer d representing the depth of the grid.
* Line 4: An integer n representing the number of lines for the grid.
* Next n lines: A string s representing 1 line of 3D Bobville.

# Output
* n lines: A line of Bobville's brightness.

# Constraints
* 1 ≤ l, w, d ≤ 20
* 1 ≤ n ≤ 450
