# Puzzle
**X egg problem** https://www.codingame.com/training/hard/x-egg-problem

# Goal
There is a building with N floors. You have X identical eggs.  
One of the floors (from 0 to N) is the highest in the building you can drop an egg from without breaking it. If you drop the egg from a higher floor, the egg will break. If you drop the egg from this floor or below, the egg will not be broken. If an egg is not broken after the drop, it keeps its same physical condition and you can use it again.  
What is minimal amount of egg drops required in worst case to find out this highest floor from which the egg will not be broken?

It is recommended to solve "The Two Egg problem" first.

# Input
* Line 1: Integer N - number of floors in a building.
* Line 2: Integer X - number of available eggs.

# Output
* Minimal amount of egg drops in worst case required to find out the highest floor from which the egg will not be broken.

# Constraints
* 1 ≤ N ≤ 1000000
* 1 ≤ X ≤ 20
