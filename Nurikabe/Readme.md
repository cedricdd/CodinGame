# Puzzle
**Nurikabe** https://www.codingame.com/training/expert/nurikabe

# Goal
Nurikabe is a Japanese number logic game in the same vein as Sudoku and Kakuro. It only requires pure logic, no particular math knowledge is necessary.

You start with a grid representing an island group seen from above, your goal is to find the shape of each island and fill the rest with water.   
Clues are given to you in the form of numbers, each number belongs to a distinct island and tells you the surface of its island.   
Diagonals do not count as links in Nurikabe, so each island must contain the right number of continuous cells. Additional rules apply to water, see the formal rules definition below.

Here's an example and its solution, . being an empty cell and ~ being water :
```
.....     ~~~~3
1....     1~4~3
....3     ~~4~3
...4.     2~44~
2....     2~~~~
```

If you want to get a better feel for the game, you can play it online at https://www.puzzle-nurikabe.com

Formal rules definition:  
- Each island contains exactly one clue.
- The number of cells in each island equals the value of the clue.
- Clues can range from 1 to a maximum of 9.
- All islands are isolated from each other horizontally and vertically.
- There are no water areas of 2x2 or larger.
- When completed, all water cells form a continuous shape (again, diagonals do not count).
- Each given grid has a unique solution.

Use this knowledge to your advantage, good luck!

Note : if you're looking for a personal challenge, it is possible to solve this puzzle without any backtracking.

# Input
* First line : N, the grid side length. Grids are always square.
* Next N lines : the grid rows, containing either integer clues or . for empty cells.

# Output
* N lines representing the solved puzzle. Use ~ for water cells and fill the islands with their size.

# Constraints
* 5 <= N <= 20
