# Puzzle
**Pentomino Pathfinding** https://www.codingame.com/contribute/view/122247e2efdd13526c7793259b53ac28c8e524

# Goal
In the Tetrisverse, houses are made using a very specific protocol : pieces are added to a blank map - a raw map of the surrounding area only consisting of pre-existing walls - to form houses for the locals.  
Before building the houses, you have been asked to check if the map follows the SHR ("special housing rules"):  
* Every piece added must be a pentomino, meaning every piece must be exactly 5 adjacent tiles.
* Every pentomino may not appear more than maxCount
For technical reasons, you also need to give the diameter of the map, which is the longest shortest path between two tiles

Here is a list of all pentominoes (with their "canonical" names) :
```
  F  | I | L  | N  | P  | T   | U  | V   | W   | X   | Y  | Z   |
     |   |    |    |    |     |    |     |     |     |    |     |
  OO | O | O  |  O |  O | OOO | OO | O   | O   |  O  |  O | OO  |
 OO  | O | O  | OO | OO |  O  | O  | O   | OO  | OOO | OO |  O  |
  O  | O | O  | O  | OO |  O  | OO | OOO |  OO |  O  |  O |  OO |
     | O | OO | O  |    |     |    |     |     |     |  O |     |
     | O |    |    |    |     |    |     |     |     |    |     |
```


Examples :
```
#######
#.....#
#.....#
#.....#
#######
```
(with maxCount = 1) is a valid map (no piece means every piece follow the rules

```
#######
#.OOO.#
#.O...#
#.O...#
#######
```
(with maxCount = 1) is a valid map

```
#######
#.SSS.#
#.S...#
#.S...#
#######
```
(with maxCount = 1) is a valid map (the character used to represent a piece has no importance)

```
#########
#.OOO..A#
#.O....A#
#.O..AAA#
#########
```
(with maxCount = 1) is an invalid map (the V pentomino appears twice, and 2 > 1)

```
#########
#.OOO..A#
#.O....A#
#.O..AAA#
#########
```
(with maxCount = 2) is a valid map

# Input
* Line 1: Two integers width and height
* Line 2: 1 integer maxCount (each pentomino cannot appear more than this value)
* Height lines (the map), consisting of either . (empty cells), # (walls) or any other character (a piece)

# Output
* Two lines:
  * If the map contains invalid pieces OR has a piece appearing more than maxCount times : "Board is invalid."; else "Board has valid pieces."
  * The diameter of the map, defined by the longest shortest path (0 if the map is invalid)

# Constraints
* The map has no enclosed areas (it is connex)
* 1 <= <width, height <= 30
