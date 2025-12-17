# Puzzle
**The Highest Building** https://www.codingame.com/training/hard/the-highest-building

# Goal
You are given an ASCII-Art picture of the city line. You must find and print the tallest building in the city. If there are multiple buildings of maximal height, print all of them, keeping them in the order they have in the input picture, from left to right.

- Buildings are made of segments represented by a hash sign #.
- There are no holes. In other words, every segment is either on the ground or on another segment.
- There is at least one building in the picture.
- Buildings are separated by at least one space.

# Input
* Line 1: Two space-separated integers W and H, representing the picture's width and height.
* Next H lines: Picture made of spaces and hash marks #.

# Output
* Pictures of all highest buildings, separated by an empty line, keeping the input order.
* Buildings should be printed without any spaces on their right side.

# Constraints
* 1 <= W < 100
