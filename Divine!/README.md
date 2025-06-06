# Puzzle
**Divine!** https://www.codingame.com/training/medium/divine

# Goal
In a typical match-3 game, the goal is to create alignments of 3 or more identical tokens by swapping two adjacent tokens.

Your program must implement a hint system for a match-3 game by listing all pairs of tokens that could be swapped to generate horizontal or vertical alignements of 3 or more tokens within a 2D grid of 9 rows by 9 columns.

The pairs must be given ordered by row, then colum, i.e. from top left to bottom right.  
A given pair must be given only once, i.e. if you report (A,B) you must not report (B,A) as well.  
For instance, if the token at row 5 and column 7 can be swapped with each of its four neighbors, then the expected report is:
```
4 7 5 7
5 6 5 7
5 7 5 8
5 7 6 7
```

# Input
* 9 lines: 9 integers, separated by spaces. Each value represents a given kind of token.

# Output
* Line 1: N, the number of pairs
* N next lines: one pair expressed as 4 space-separated integers representing the row and column of swappable pairs, i.e. row1 col1 row2 col2
