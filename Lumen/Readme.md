# Puzzle
**Lumen** https://www.codingame.com/training/easy/lumen

# Goal
THEY put you in a square shape room, with N meters on each side.  
THEY want to know everything about you.  
THEY are observing you.  
THEY placed some candles in the room.  

Every candle makes L "light" in the spot they are, and every spot in square shape gets one less "light" as the next ones. If a spot is touched by two candles, it will have the larger "light" it can have. Every spot has the base light of 0.

You can hide only, if you find a dark spot which has 0 "light".  
How many dark spots you have?

You will receive a map of the room, with the empty places (X) and Candles (C) in N rows, each character separated by a space.

```
Example for the light spread N = 5, L = 3:
X X X X X
X C X X X
X X X X X
X X X X X
X X X X X

2 2 2 1 0
2 3 2 1 0
2 2 2 1 0
1 1 1 1 0
0 0 0 0 0
```

# Input
* Line 1: An integer N for the length of one side of the room.
* Line 2: An integer L for the base light of the candles.
* Next N lines: N number of characters (as c), separated by one space.

# Output
* Line 1 : The number of places with zero light.

# Constraints
* 0 < N <= 25
* 0 < L < 10
