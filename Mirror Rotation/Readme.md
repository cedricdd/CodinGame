# Puzzle
**Mirror Rotation** https://www.codingame.com/contribute/view/128220d7d48cf1b3296d0820b26b3c5ff42fbe

# Goal
You’re trapped in a room and need to escape by hitting a target with a laser. The laser can’t reach the target directly—you must use mirrors to reflect the beam toward the target.

You are given:  
- w: the room's length (left to right)
- h: the room's width (top to bottom)
- A map of the room, like this:

```
 //#\\  
 ..#..  
 .T#..  
 \../L
```

Each character in the map represents:
- L: the laser’s starting position
- T: the target
- .: empty space
- \#: wall (blocks beam)
- /: a mirror from top-right to bottom-left
- \: a mirror from top-left to bottom-right

The top-left corner is coordinate (0, 0).  
You are also given the laser’s initial direction:  
- N (north = up)
- E (east = right)
- S (south = down)
- W (west = left)

When the beam hits a mirror, it reflects at a 90-degree angle:  
- / turns N ↔ E and S ↔ W
- \ turns N ↔ W and S ↔ E
The beam can pass through the laser.

Find the minimum number of mirrors to flip (change / to \ or \ to /) so that the laser beam reaches the target T.

Print the coordinates of the mirrors you need to flip, one per line, in reading order (top to bottom, left to right).

The solution for the given example is:
```
1 0
3 0
```
(The direction is North for that one).

# Input
* Line 1: 2 space-separated integers l and w.
* Next w lines: A string s representing a line of the map.
* Next line: A string dir representing the direction the laser is facing (N, E, S, W)

# Output
* Minimum number of mirrors needed to flip lines: 2 space-separated integers - the coordinates (column, row) of the mirror needed to flip. The mirrors should be listed in reading order.

# Constraints
* 2 ≤ l, w ≤ 10
* 1 ≤ number of mirrors ≤ 16
* The beam will always be able to reach the target after flipping at least one mirror.
