# Puzzle
**The Shifting Labyrinth** https://www.codingame.com/contribute/view/120597257e18c74d393ef980a8cc2db1e33517

# Goal
Navigate through a labyrinth where the walls shift at every step! Your task is to find the shortest path from the start to the exit, but beware: the labyrinth changes dynamically based on a set of rules that you need to compute before each move.

The labyrinth is a N by M grid containing:  
* ., the empty spaces where you can move.
* #, the walls you can't pass through.
* S, the starting position, exactly one in the grid.
* E, the exit position, exactly one in the grid.

After every K-th step, the walls shift. The walls shift right if the row index is odd and left if the row index is even. If a wall moves beyond the grid's boundary, it wraps around to the opposite edge. You can only move up, down, right, and left.  
Rows are from top to bottom, and they use 0-based indexing.  

# Input
* Line 1: An integer N, representing the number of rows.
* Line 2: An integer M, representing the number of columns.
* Line 3: An integer K, representing the number of steps after which the walls shift.
* Next N Lines: A string containing M characters of either ., #, S, or E.

# Output
* Line 1: The minimum number of steps required to reach the exit (E) from the starting position (S). If it is impossible to reach the exit, output IMPOSSIBLE.

# Constraints
* 5 ≤ N, M ≤ 20
* 1 ≤ K ≤ 10
