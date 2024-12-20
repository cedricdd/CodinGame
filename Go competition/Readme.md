# Puzzle
**Go competition** https://www.codingame.com/training/medium/go-competition

# Goal
Go is an abstract strategy board game for two players, in which the aim is to surround more territory than the opponent.  
At the end of the game, you have to determine which player is the winner by counting which one has the biggest territory.  

Area scoring: A player's score is the number of stones that he has on the board, plus the number of empty intersections surrounded by that player's stones.

BLACK is always first so WHITE starts with 6.5 points also known as "komi".

Every board is in a stable position, you only have to calculate the territories.

Example (with only a 4x4 grid):
```
.BW.
BBWW
.BW.
BBWW
```

After transformation we have:
```
bBWw
BBWW
bBWw
BBWW
```

```
6B + 2b = 8 for BLACK
6W + 2w + 6.5(komi) = 14.5 for WHITE
```

WHITE is the winner.

# Input
* Line 1: An integer L for the number of lines of the go board
* Next L lines: Each line is the state of the board, . represents an empty intersection , B a BLACK stone and W a WHITE stone.
* Each line contains L characters.

# Output
You have to print:
* WHITE : score
* BLACK : score
* BLACK/WHITE WINS

WHITE score always ends with ".5"

# Constraints
* L is in [ 9 , 13 , 19 ]
* L lines contains only [ . , B , W ] characters
