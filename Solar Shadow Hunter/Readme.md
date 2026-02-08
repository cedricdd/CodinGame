# Puzzle
**Solar Shadow Hunter** https://www.codingame.com/contribute/view/142575488b2ef02949980aa78f1ee989a3dd7a

# Goal
Calculate the total power output of a solar roof by simulating vertical shadows.

The roof is represented as a grid of width W and height H. The sun is positioned at the bottom (South) of the map and shines towards the top (North).

You need to calculate how much power the solar panels P produce, considering that obstacles (1-9) cast shadows.

Shadow Rules:
* Obstacles cast shadows vertically towards the top (North).
* The length of a shadow is determined by the formula: Length = Obstacle height × K (shadow coefficient).
* A shadow covers the Length cells directly above the obstacle.

Power Rules:
* Each unshaded Solar Panel P produces 100 Watts.
* Any panel covered by a shadow produces 0 Watts.
* Obstacles themselves do not produce power.

# Input
* Line 1: Two integers W and H for the width and height of the map.
* Line 2: An integer K (shadow coefficient).
* Next H lines: A string representing a row of the roof map using ., P, and 1-9.

# Output
* Line 1: An integer representing the total power generated.

# Constraints
* 1 ≤ W, H ≤ 50
* 1 ≤ K ≤ 5
