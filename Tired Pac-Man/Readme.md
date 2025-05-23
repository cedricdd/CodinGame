# Puzzle
**Tired Pac-Man** https://www.codingame.com/contribute/view/110400e725a87f10e3be99500a4d221a29f20c

# Goal
Pac-Man has had a long day of eating fruit and avoiding ghosts, so he now only has limited energy. The objective is to maximize the score by eating fruit before his energy runs out.

Pac-Man can only move in the cardinal directions (North, East, South, and West), and each move costs 1 energy.

Pac-Man can also wrap around the edges of the grid:  
* Moving from the top edge to the bottom edge, or from the bottom edge to the top edge, costs 3 energy.
* Moving from the left edge to the right edge, or from the right edge to the left edge, also costs 3 energy.

Pac-Man avoids being near ghosts:  
* He WILL NOT move into or within one square of a ghost in any of the cardinal directions (North, East, South, and West).
* Ghosts CAN also wrap around the edges of the grid.

In the grid:  
* P represents Pac-Man's starting position.
* G represents a ghost.
* \# represents an impassable barrier.
* A space represents an empty square.
* Fruits are represented as follows:
  * \* is worth 5 points.
  * . is worth 1 point.
  * ) is worth 3 points.

Eating Fruit:  
To eat a fruit and gain that fruit's points, Pac-Man must move into the square that the fruit occupies. Once a fruit has been eaten, it CANNOT be eaten again.

# Input
* Line 1 : Space separated integers representing the width w and height h of the grid.
* Line 2: Integer representing Pac-Man's energy.
* Next h lines: String of length w representing a row of the grid.

# Output
* Integer of maximum achievable score from P within the given energy limit.

# Constraints
* 2 ≤ h,w ≤ 60
* 0 ≤ energy ≤ 25
* There will always be exactly one Pac-Man.
* Grid contains only the following characters: P, G, #, *, ., ) and space.
