# Puzzle
**Polyominos** https://www.codingame.com/contribute/view/118617e82691f956c4a6959ea420471eeae900

# Goal
Fill the given 2D shape completely by placing all the provided polyominoes.
  
You will be given a predefined shape that must be entirely covered using the available polyominoes.
* Each polyomino can be rotated by 0°, 90°, 180°, or 270°.
* Polyominoes can also be flipped horizontally or vertically, giving each piece up to 8 possible orientations.
* Below is an overview of all polyominoes used in the puzzle:

![pieces](https://github.com/user-attachments/assets/8a11c0e4-245c-4759-9cb5-b0b724bf3ed7)

Consider the first test case. You need to use the A and D polyominoes (in this order - see the Game Input section) to completely fill the following shape:
```
OOO
OOO
O.O
```
There are two possible solutions:
```
DAA      AAD
DDA  or  ADD
D.A      A.D
```

If you choose the second variant, your output should consist of 2 lines. Or 1 for each game turn:
```
(0,0) (0,1) (1,0) (2,0)
(0,2) (1,1) (1,2) (2,2)
```

Explanation:
* The first line represents polyomino A (L-shaped), placed at position (0,0) with its short side facing up and the long side extending left.
* The second line represents polyomino D, positioned at (0,2) and rotated to fit the remaining space.

# Input
Every turn you will receive current configuration in following format:  
* Line 1: ids of remaining polyominos to place on board for example: ABEFN
* Line 2: id of polyomino to place in this turn for example: F
* Line 3: space separated h - height and w - width of game board
* Following lines: h strings of length w representing game board, where:
    * . - have to remain unoccupied
    * O - is not yet occupied
    * A through N - is occupied by shape 

# Output
* Line: n space separated pairs of (row,column) values representing each block of current polyomino.

# Constraints
* Allotted response time to output is ≤ 2s in first turn and 50ms in remaining turns
