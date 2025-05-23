# Puzzle
**Locked in gear** https://www.codingame.com/training/medium/locked-in-gear

# Goal
A number of gears are placed on a grid. The first gear is driven in a clockwise direction. Your goal is to determine the turning direction of the last gear.

# Input
* Line 1: an integer N corresponding to the number of gears (at least 2)
* Next N lines: the properties of the gears, given as:
  - the coordinates of center of the gear, given by two integers x and y
  - the radius of the gear, given by an integer r

# Output
* A single line, stating the direction of the last gear from the input. The direction can be one of the following:
  - CW for a clockwise movement,
  - CCW for a counterclockwise movement,
  - NOT MOVING if the gear doesn't move at all.

# Constraints
* 2 ≤ N ≤ 1000
* 0 ≤ x ≤ 1000
* 0 ≤ y ≤ 1000
* 1 ≤ r ≤ 1000
* The gears do not overlap.
