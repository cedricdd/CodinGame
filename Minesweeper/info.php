https://www.codingame.com/training/medium/minesweeper-1

The Goal
Find all mines without detonating any of them.

Rules
You are given a grid of size 30x16. There are 99 mines hidden on the board.
You can reveal any cell. If said cell is a mine, you lose the game. Otherwise you will be told the amount of mines neighboring it (including diagonal neighbors).
  
Expert Rules
The top left corner has the coordinates (0, 0)
You can find the source code of the game on https://github.com/eulerscheZahl/minesweeper.

There is one single testcase that's randomly generated after your first action. Your first action will always reveal multiple cells at once.
Due to the randomness you may have to submit multiple times to solve the puzzle but a good solver won't require many attempts.

Input

16 lines with 30 space separated characters each:
    ? for an unknown cell
    . for a revealed cell without any mines next to it
    1-8 for a revealed cell with the corresponding amount of mines next to it

Output
A single line x y indicating that you want to reveal that cell.
You can add further points to indicate mines. These are purely visual and have no effect on the game.
Example: 1 2 3 4 will reveal the cell (1, 2) and place a flag at (3, 4).

Constraints
width = 30
height = 16
mineCount = 99

Allotted response time to output is ≤ 50ms per turn (1s for the first turn).
