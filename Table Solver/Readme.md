# Puzzle
**Table Solver** https://www.codingame.com/contribute/view/130266db6c6333748aadb210c9a144deaf8fa6

# Goal
You are given a table like this:
```
+ |  |7 |  |14
______________
9 |  |  |  |  
______________
5 |10|  |  |19
______________
  |  |  |  |16
______________
11|  |18|22|  
```

The character | is used to separate table cells in the same row, and the character _ is used to draw horizontal separators between rows.

The symbol in the top-left corner indicates an operation: +, -, or x (multiplication).  
Every cell in the table—except those in the topmost row or leftmost column—must equal the result of applying that operation to the corresponding row header (the leftmost cell in its row) and column header (the topmost cell in its column).

Some cells in the table are already filled in, while others are left blank. Your goal is to fill in all missing values so that the entire table strictly follows the operation rule. Headers themselves may also be partially missing and might need to be deduced from the known values within the grid.

Each number in the grid is formatted to occupy a space equal to the length of the longest number (including a negative sign if present), ensuring neat alignment. Each number is left-aligned and padded with spaces on the right, if necessary.

Note: Every provided grid is guaranteed to be solvable logically—no guesswork or trial-and-error is needed.  
Note: Subtraction is subtracting the leftmost column from the topmost row.  

# Input
* Line 1: An integer inputLines — the total number of lines of the table
* Next inputLines lines: A string s — a row in the table, including the horizontal separators.

# Output
* inputLines lines: The completed table.
* The trailing spaces in each line should not be removed.

# Constraints
* 2 ≤ Number of columns, Number of rows ≤ 15
* Every number in the completed table is an integer between -10⁵ and 10⁵.
