# Puzzle
**Self-driving car testing** https://www.codingame.com/training/easy/self-driving-car-testing

# Goal
Display the trajectory of a self-driving car on the road, from its log file.

The self driving car is represented by a hash mark # and the pattern of the road to display is given in the log file.  
On an ASCII vertical scrolling, you display the car on each portion of the road.

Each command logged by the car is represented by an integer and a char (L for left, R for right, S for straight).  
For example: 4S;3R means the car is moving four times straight ahead, then three times to the right (from a sky point of view)

# Input
* Line 1: The number N of lines describing the road pattern
* Line 2: The position X (starting from 1) of the car at the beginning, then a list of command separated by a semi-colon ;
* N next lines: The number R of similar consecutive patterns, then, separated with a semi-colon ; the pattern of the road to be repeated R times.

# Output
* The road, line by line, with the character # representing the self driving car at its current position
