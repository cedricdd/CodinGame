# Puzzle
**Hanoi tower** https://www.codingame.com/training/hard/hanoi-towerhttps://www.codingame.com/training/hard/hanoi-tower

# Goal
The classic game of Hanoi tower consists of a stack of wooden disks of various, unique size and three axes.  
At the beginning of the game, all disks are stacked on the left axis, in decreasing size (largest disk at the bottom).  
The goal of the game is to move the entire stack to the right axis, moving one disk at a time and always placing a disk on an empty stack or a larger disk.  

A trivial algorithm for solving the game is the following:  
- move the smallest disk one axis to the right if the number of disks is even, to the left if the number of disks is odd
- then make the single other possible move not involving the smallest disk
- reiterate this process until the stack is fully on the rightmost axis

You must write a program that implements this algorithm and:  
1. computes the number of steps required to complete the game
2. displays the state of the game after a given number of turns

# Input
* Line 1: N , the number of disks.
* Line 2: T, the turn for which you must display the game state

# Output
* N lines: a graphical representation of the game state at turn T:
  - the three axes must be evenly spaced to accommodate all disks and are N lines high
  - the empty parts of the axes are represented with the character |
  - disks are represented with the character #, on each side of the axis and on the axis itself
  - the smallest disk has radius 1, the largest disk has radius N, i.e. a disk with radius 2 is effectively 5 chars wide, including the axis in the middle
  - axes are separated by a single space
  - do not output spaces at the end of lines
* Following line: the number of turns needed to complete the game

# Constraints
* 3 <= N <= 10
* 1 <= T <= 2^N-1
