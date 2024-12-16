# Puzzle
**Killer Sudoku Solver** https://www.codingame.com/training/medium/killer-sudoku-solver

# Goal
You may know the sudoku puzzle. Killer sudoku adds a new rule with cages.  
A cage is a group of cells, the sum of which must equal the cage value. Numbers cannot repeat within cages.  

Here are the 4 rules of killer sudoku:
1. Each row must have numbers from 1 to 9 with no repetition
2. Each column must have numbers from 1 to 9 with no repetition
3. Each region (3x3 square) must have numbers from 1 to 9 with no repetition
4. Each cage's cell numbers must sum to the cage value, with no repetition among numbers

The cages are represented in a 9x9 grid with an identifier from a to z and A to Z as follows (first test case):
```
56..1..2. aabbccdde
..72..68. afghhiide
..2.87.15 jfggklmme
......3.9 jjgnklopp
.7....2.. qqgnooorr
9.634.8.. stuuvwwxx
2.9..8... stuuvvwyz
..41.2... sAuuByyyz
.8.4...3. CADDBEEFF
```
```
*-----------------------------------*   *-----------------------------------*
| 5   6 |       | 1     |     2 |   |   | a   a | b   b | c   c | d   d | e |
|   +---+---+---+---+---+---+   +   |   |   +---+---+---+---+---+---+   +   |
|   |   | 7 | 2     |     6 | 8 |   |   | a | f | g | h   h | i   i | d | e |
|---+   +   +---+---+---+---+---+   |   |---+   +   +---+---+---+---+---+   |
|   |   | 2     | 8 | 7 |     1 | 5 |   | j | f | g   g | k | l | m   m | e |
|   +---+   +---+   +   +---+---+---|   |   +---+   +---+   +   +---+---+---|
|       |   |   |   |   | 3 |     9 |   | j   j | g | n | k | l | o | p   p |
|---+---+   +   +---+---+   +---+---|   |---+---+   +   +---+---+   +---+---|
|     7 |   |   |         2 |       |   | q   q | g | n | o   o   o | r   r |
|---+---+---+---+---+---+---+---+---|   |---+---+---+---+---+---+---+---+---|
| 9 |   | 6   3 | 4 |     8 |       |   | s | t | u   u | v | w   w | x   x |
|   +   +       +   +---+   +---+---|   |   +   +       +   +---+   +---+---|
| 2 |   | 9     |     8 |   |   |   |   | s | t | u   u | v   v | w | y | z |
|   +---+       +---+---+---+   +   |   |   +---+       +---+---+---+   +   |
|   |   | 4   1 |   | 2         |   |   | s | A | u   u | B | y   y   y | z |
|---+   +---+---+   +---+---+---+---|   |---+   +---+---+   +---+---+---+---|
|   | 8 |     4 |   |       | 3     |   | C | A | D   D | B | E   E | F   F |
*-----------------------------------*   *-----------------------------------*
```

You can find playable killer sudoku here: https://sudoku.com/fr/killer.

# Input
* First 9 lines: First 9 characters: the sudoku grid with empty cells represented by . character, Last 9 characters: cage ID for each of the nine cells in this row of the sudoku grid.
* Line 10: The list of the cages with sum of the cells cage ID=value

# Output
* 9 lines: Solution for the sudoku

# Constraints
* Each test case has only one solution
