# Puzzle
**High-rise buildings** https://www.codingame.com/training/expert/high-rise-buildings

# Goal
Given a grid of dimension NxN, you must build towers on each square in such a way that:
- The heights of the towers range from 1 to N;
- Each row contains every possible height of tower exactly once;
- Each column contains every possible height of tower exactly once;
- Each numeric clue describes the number of towers that can be seen if you look into the square from that position. Taller towers block your view of shorter towers behind them.

Clues are given in this order North, West, East and South.
```
   a  b  c                  2  1  2
d  .  .  .  g            2  .  3  .  2
e  .  .  .  h            1  .  .  .  3
f  .  .  .  i            2  .  .  .  1
   j  k  l                  2  3  1
```


Here we must put a building of height 3 because we can see only one tower from position b.

# Input
* Line 1: One integer N for the size of the grid.
* Line 2: N integers for the numbers of visible towers from the North, given from left to right.
* Line 3: N integers for the numbers of visible towers from the West, given from top to bottom.
* Line 4: N integers for the numbers of visible towers from the East, given from top to bottom.
* Line 5: N integers for the numbers of visible towers from the South, given from left to right.
* Next N lines: A string containing N digits indicating the heights of the towers (0 means unknown)

# Output
* Grid with the buildings heights
* N lines N space-separated digits

# Constraints
* 5 ≤ N ≤ 8
