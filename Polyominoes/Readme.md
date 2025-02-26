# Puzzle
**Polyominoes** https://www.codingame.com/contribute/view/118617e82691f956c4a6959ea420471eeae900

# Goal
Your task is to carefully arrange all the given polyominoes to perfectly fill the predefined shape. Rotate and flip the pieces as needed, but make sure everything fits!

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
So you should print either one of them. 

# Input
* Line 1: ids of remaining polyominoes to place on board for example: ABEFN
* Line 2: space separated h - height and w - width of game board
* Following lines: h strings of length w representing game board, where:  
   * . - must remain unoccupied
   * O - must be occupied 

# Output
* h lines of length w representing final board where:
   * . - is unoccupied
   * A-N - as ID of polyomino that covers given cell 

# Constraints
* Maximum of 14 ids
* 2 < h, w < 20
* Allotted response time to output is ≤ 2s
