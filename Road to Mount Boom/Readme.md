# Puzzle
**Road to Mount Boom** https://www.codingame.com/training/easy/road-to-mount-boom

# Goal
A legendary item has been rediscovered by Brodo and must be destroyed to prevent the Dark Lord's return to power. The only way to destroy the item is for Brodo to travel to Mount Boom and to cast it into the flames. The goal is to find the SHORTEST DISTANCE for Brodo to reach Mount Boom.

Movement:  
Brodo can move in any CARDINAL or ORDINAL direction (N, NE, E, SE, S, SW, W, NW). A movement of 1 in any direction represents a distance of 1 league.

Brodo CANNOT travel onto mountains, nor can he move diagonally between two mountains that are adjacent to each other.  
Mountains are considered adjacent if they are within 1 league in any direction.  

Example:  
Brodo cannot move from B to M, or vice versa, in the following map:  
B^  
^M  

Map Legend:  
* B - Brodo's starting location.
* M - Mount Boom (goal destination).
* ^ - Mountain.

Space - Empty path Brodo can traverse, following the movement rules above.

# Input
* Line 1: Space separated integers representing the height and width of the map, in the form: h w.
* Next h lines: String of length w representing a section of the map.

# Output
* Integer of the shortest distance from Brodo's starting position to Mount Boom, in the units league(s).

# Constraints
* 1 ≤ h ≤ 100
* 1 ≤ w ≤ 100
* Map contains only a single B and M.
