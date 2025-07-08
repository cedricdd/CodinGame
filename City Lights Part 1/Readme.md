# Puzzle
**City Lights Part 1** https://www.codingame.com/training/easy/city-lights-part-1

# Goal
The 3D city of Bobville can be displayed as a 2D grid with height h and width w.  
Each cell contains either a . or a single character representing a light source radius:  
- 1 to 9 represent radius 1 to 9
- A to Z represent radius 10 to 35 (A=10, B=11, ..., Z=35)

If lit, the brightness from that source on the cell is:
```brightness = radius - d```

where d is the Euclidean distance from the source cell center to the target cell center, rounded to the nearest integer.

If multiple sources light a cell, add their brightness values.  
If no source lights a cell, its brightness is 0.  
If the brightness calculated using the formula results in a negative value, it should be treated as 0.  

Output the full grid of Bobville showing the brightness of each cell, using:  
- 0–9 for brightness 0–9
- A–Z for brightness 10–35

Note: For a value above Z (like 36), it is still Z.  
Note: The brightness applies uniformly to a whole cell.  

# Input
* Line 1: An integer h representing the height of the grid.
* Line 2: An integer w representing the width of the grid.
* Next h lines: A string s with length w representing 1 line of Bobville.

# Output
* h lines: A line of Bobville's brightness.

# Constraints
* 1 ≤ h, w ≤ 20
