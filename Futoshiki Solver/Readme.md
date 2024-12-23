# Puzzle
**Futoshiki Solver** https://www.codingame.com/training/medium/futoshiki-solver

# Goal
Futoshiki is a Japanese numeric logic puzzle similar to the more popular Sudoku.  
See https://en.wikipedia.org/wiki/Futoshiki  
Like in Sudoku, in a Futoshiki of size n every row and every column must contain every number from 1 to n.  
Unlike Sudoku there may be greater than / less than relations between cells.  

For a n×n Futoshiki the input will be 2n-1 lines of digits 0..n (0 meaning empty), and either spaces or inequality constraints ^ v < > separating the digits of length 2n-1.

^ meaning the cell below the symbol has a higher value than the one above the symbol and so on.

Example: A 2×2 Futoshiki
```
0>0
v ^
0<0
```
having the solution:
```
21
12
```

# Input
* Line 1: number size of lines to read
* Next size lines:
    - even-numbered lines: string of length size alternating between a number 0..n and a space or < or >.
    - odd-numbered lines: string of length size containing spaces and v or ^ on even-numbered positions and spaces on odd-numbered positions.

# Output
* n lines: n digits for each row of the solved board (for n such that size = 2×n - 1)

# Constraints
* There is only 1 correct solution to each board.
* 1 ≤ size ≤ 13
