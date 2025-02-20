# Puzzle
**Jumping Frog** https://www.codingame.com/training/medium/jumping-frog

# Goal
You are given a grid of size N*N representing a lake. It is composed of water lily (#) or water (.)  
You have to find the length of the longest path that a frog can take without going twice on the same water lily and never fall in the water.  

The frog can jump of 1 or 2 squares in the four principal directions or jump of one square in diagonals.

Be careful with the beginning coordinates of the frog. (0,0) is the top left corner of the grid.

There may be more than one longest path, but they all have the same length. For the example, the longest path is of 7 water lilies and you can find different paths of this length :
```
12.        13.        17.
.34   or   .24   or   .26
765        657        354
```
and many others...

# Input
* Line 1 : an integer N the size of the lake
* Next N lines : a string representing a line of the grid (# or . )
* Next 2 lines : the beginning coordinates xd and yd of the frog (integers)

# Output
* An integer which is the length of the longest path possible for the frog.

# Constraints
* 3 <= N <= 15
