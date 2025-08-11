# Puzzle
**Connect the Colours** https://www.codingame.com/contribute/view/129408a417d97f1bbc14444ce623ef6495dcba

# Goal
Connect the Colours is a logical puzzle that involves connecting pairs of matching colours in a closed grid. The objective is to connect ALL pairs of identical colours with non-overlapping paths, using EVERY tile.
  
Rules:  
* Paths must consist of one or more horizontal and or vertical segments to connect adjacent tiles.
* Each colour must be connected to the other instance of the same colour using a continuous path.
* A single tile can only be used in ONE path and any two paths CANNOT overlap or cross each other.
* Paths must remain entirely within the grid boundaries.
* Every tile must be used in a path, so that there are no empty tiles remaining.

The top-left corner is positioned at coordinates (0,0) and the bottom-right is positioned at coordinates (w-1,h-1).

Victory Conditions  
* All colours are connected to their respective identical colour, in a continuous path and without overlaps or crossovers. 

Loss Conditions  
* Response time exceeds the time limit.
* The output is not properly formatted.
* Attempted to create an invalid path.
* Number of turns exceeds the turn limit.

# Input
* Line 1: Space separated integers h w representing the height and width of the puzzle.
* Next h Lines: String of length w representing a row of the puzzle.
* Integers are used to define colours. Matching integers represent the same colour.
* The full stop character (.) indicates an empty tile that can be used as part of a path.

# Output per turn
A single line containing integers in the form x1 y1 x2 y2 colour.  
* x1 - X-Coordinate of the first tile.
* y1 - Y-Coordinate of the first tile.
* x2 - X-Coordinate of the second tile.
* y2 - Y-Coordinate of the second tile.
* colour - Colour identifier. 

This will create a section of a path from the first tile, to the second tile and will be in the colour denoted by the colour identifier.  
Tiles MUST be in the same plane either horizontally or vertically (x1 = x2 OR y1 = y2).   

# Constraints
* 1 ≤ h, w ≤ 10
* Allotted response time for first output is 2 seconds.
* Allotted response time for subsequent outputs is 50 ms.
* Turn limit is 60 turns.
* A colour identifier will appear exactly twice within a puzzle.
* Maximum number of distinct colours in a puzzle is 9.
