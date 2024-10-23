# Puzzle
**Island Escape** https://www.codingame.com/contribute/view/1092129119d92582daee02f28f01f1339e8986

# Goal
You're dropped onto an island, starting at the very middle of an N by N terrain. Luckily you have a raft and a map showing the elevation of each square plot of land. The ocean lies all along the borders of the map at elevation 0.

You can move directly north, south, east, or west to an adjacent plot, provided the difference in elevation is at most one. Larger differences indicate steep terrain which cannot be traversed carrying your raft. Determine yes or no if it's possible to reach the ocean and get away.

# Input
* Line 1: An odd integer N for the size of the map
* Next N lines: Space-separated integers for the elevation of each plot (of which there are N in the row)

# Output
* Line 1: yes if the ocean is reachable, otherwise no

# Constraints
* 2 < N < 20
* N is odd
* 0 ≤ elevation < 10
