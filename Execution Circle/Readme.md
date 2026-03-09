# Puzzle
**Execution Circle** https://www.codingame.com/training/hard/execution-circle

# Goal
People are standing in a circle waiting to be executed. Counting begins at a specified point in the circle and proceeds around the circle in a specified direction. starting from S, the next person is executed. The procedure is repeated with the remaining people, starting with the next person alive and going in the same direction, until only one person remains, and is freed.

The problem — given the Number of people , Starting point and Direction — is to choose the position in the initial circle to avoid execution.

example:
```
N=8
S=5
D=LEFT

  1
 8 2
7   3
 6 4
  5
```
```
5 kills 6

  1
 8 2
7   3
 X 4
  5
```
```
7 kills 8

  1
 X 2
7   3
 X 4
  5
```
```
1 kills 2

  1
 X X
7   3
 X 4
  5
```
```
3 kills 4

  1
 X X
7   3
 X X
  5
```
```
5 kills 7

  1
 X X
X   3
 X X
  5
```
```
1 kills 3

  1
 X X
X   X
 X X
  5
```
```
5 kills 1

  X
 X X
X   X
 X X
  5

5 is freed
```

# Input
* Line 1: Two space-separated long integers indicating the Number of people and the Starting point
* Line 2: The word LEFT (clockwise) or RIGHT (counter-clockwise) for the Direction to take

# Output
* The winning position

# Constraints
* 0 < N < 10000000000000
* 0 < S < 10000000000000
