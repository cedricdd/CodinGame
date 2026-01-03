# Puzzle
**Echoes in the Grid** https://www.codingame.com/contribute/view/140496a98cf3dd8443e7d9c8e89973dbde63d0

# Goal
You are analyzing a corrupted transmission represented as a 2D grid of characters.

Some cells contain signal emitters.  
Each emitter has an initial signal power equal to its position in the alphabet (A = 1, B = 2, …, Z = 26).  

An emitter sends its signal in the four cardinal directions (up, down, left, right).  

The signal starts at full power on the emitter cell itself.  
Each step away from the emitter multiplies the signal power by DECAY.  

Signal propagation stops when it reaches the edge of the grid or a wall.  

If multiple signals reach the same cell, their powers are summed.  

Your task is to determine how many cells receive a total signal power greater than or equal to THRESHOLD.

# Input
* Line 1: Two space-separated integers H and W — height and width of the grid.
* Line 2: Two space-separated real numbers DECAY and THRESHOLD.
* Next H lines: A string of length W describing the grid:
  * \#: wall
  * \. : empty cell
  * A to Z : signal emitter (strength = position in alphabet, A = 1, Z = 26)

# Output
* Line 1: A single integer — the number of cells where the accumulated signal power is greater than or equal to THRESHOLD.
* Floating-point computations should be performed using double-precision arithmetic when determining whether the accumulated signal power meets or exceeds the threshold.

# Constraints
* 1 ≤ H, W ≤ 10
* 0 < DECAY < 1
* 0 < THRESHOLD ≤ 100
* The number of signal emitters does not exceed 10.
