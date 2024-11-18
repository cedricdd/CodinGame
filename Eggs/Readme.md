# Puzzle
**Eggs** https://www.codingame.com/contribute/view/88489969b75f7ef814764dfab5bb0497c4129

# Goal
Alice and Bob play a game in a grid of height h and width w, where they place n eggs at different random positions.
They both start at (0, 0), and:
Alice will move along the columns, going to the next column when she reaches the edge (that is, from top to bottom, and then, from left to right).
```
adgj
behk
cfil
```

Bob will move along the rows, going to the next row when he reaches the edge (that is, from left to right, and then, from top to bottom).
```
abcd
efgh
ijkl
```

The first to reach an egg is the winner. If both players reach an egg at the same time, it is considered a draw.

Give the probability of Alice winning, Bob winning or a draw, in percentage, followed by the sign %, rounded to the nearest 0.01%.

Note that the three probabilities may not add up to 100% due to rounding.

# Input
* Line 1 : An integer h for the height of the grid.
* Line 2 : An integer w for the width of the grid.
* Line 3 : An integer n for the number of eggs placed.

# Output
* Line 1 : Probability of Alice winning the game.
*  Line 2 : Probability of Bob winning the game.
* Line 3 : Probability of a draw.
* The three probabilities will be printed in percentage, followed by the sign %, rounded to the nearest 0.01%.

# Constraints
* 0 < h, w, n <= 6
* n <= h * w
