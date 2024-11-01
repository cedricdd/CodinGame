# Puzzle 
**Comet and Stars ASCII Art** https://www.codingame.com/contribute/view/106440ba55c4824ba139814235031b7c33bc30

# Goal
You are tasked with visualizing the path of a comet as it travels through space, while also marking the positions of stars along its trajectory. Given the starting and ending positions of the comet, as well as the positions of stars, your program should generate an ASCII art representation.

# Input
* Line 1 Two integers C and D (the comet's starting and destination positions), separated by a space.
* Line 2 Contains an integer N, representing the number of stars.
* Next N Lines Each contains an integer S, representing the position of each star.

# Output
* Line 1 Should contain the number line showing positions from the minimum of C and D to the maximum of C and D.
* Line 2 Should be the ASCII art representation of the comet C and stars (*).

# Constraints
* 1 ≤ C, D ≤ 50
* C ≠ D
* 1 ≤ S ≤ 50
* The positions of the stars may or may not fall within the range of the comet's trajectory.
* The comet will always be moving in a straight line, either forward or backward.
