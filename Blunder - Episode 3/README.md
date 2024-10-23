# Puzzle
**Blunder - Episode 3** https://www.codingame.com/training/hard/blunder-episode-3

Blunder is happy because hundreds of CodinGamers have re-programmed his natural behavior. The problem is that these programs aren’t all equal. Evidently, most are too fast for Blunder to fully revel in his inactivity...

Using performance measures carried out on the execution time of the programs for Blunder, your mission is to determine what's the most likely computational complexity from a family of fixed and known algorithmic complexities.

# Input
* Line 1: the number N of performance measures carried out on the same program.
* N following lines: one performance measure per line. Each line contains two values: an integer num representing the number of items that the program has processed and an integer t representing the execution time measured to process these items in microseconds. These values are separated by a space. Values of n are unique and sorted in ascending order.

# Output
* The most probable computational complexity among the following possibilities: O(1), O(log n), O(n), O(n log n), O(n^2), O(n^2 log n), O(n^3), O(2^n)

# Constraints
* 5 < N < 1000
* 5 < num < 15000
* 0 < t < 10000000
