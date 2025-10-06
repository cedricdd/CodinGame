# Puzzle
**Underwater Chase - Episode 2** https://www.codingame.com/contribute/view/7050319a812d469d1416485870e5f93363dc8

# Goal
This is the second episode of the puzzle Underwater Chase. Solving the first part before the second one is recommended.

You are the captain of a submarine and you are chasing another one. Thanks to your high-tech equipment, you and the enemy captain can hear each other giving orders to your crew.   
Unfortunately, you cannot locate each other. Your goal is to hide from the enemy by making him unable to precisely locate your subarine.

You are given a north-facing map of the ocean, with sea (marked as .) and land (marked as o), and the number of orders you must give. An order is the direction of the sub for 1km (one cell of the map).   
The sub cannot cross land or leave the map area, but neither can it cross his own path (each cell of the map can only appear once in the path).  
Given the sub starting coordinates, you must output the best sequences of directions to maximize the number of positions where you could be, followed by this number.  

Example :
```
o...
...o
.Xo.
o...
```

2 orders  
(o is land and . is sea, X is your starting position)  
Possible sequences of orders :
```
NN
NE
NW
SE
WN
```

After the sequence NN, the sub may be at any position marked with an X :
```
oX..
.X.o
..o.
o...
```

The score of this sequence is 2, because the enemy knows you can only be in 2 different cells.

The sequences NW, WN and SE have a score of 3 for the same reason.

The sequence NE is the best sequence, with a score of 4.  
Given this sequence of orders, you could be at any of the 4 following positions :
```
o.XX
.XXo
..o.
o...
```

This is the only best sequence of orders, so you must output : NN 4

This puzzle is inspired by the board game Captain Sonar.

# Input
* Line 1 : 3 space-separated integers w, h and n, respectively the width and height of the map, and the number of orders you must give.
* h next lines : a line of the map of length w. The characters can be . (ocean), o (land) or X (the position of the sub at the beginning).

# Output
* Line 1 : All the sequences of orders that maximize the number of possible positions where you could be, alphabetically sorted and space-separated, and the number of possible positions where you could be.

# Constraints
* 2 ≤ w, h ≤ 30
* 1 ≤ n ≤ 15
* There is always at least one valid path of length n.
