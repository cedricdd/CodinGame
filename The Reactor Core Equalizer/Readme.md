# Puzzle
**The Reactor Core Equalizer** https://www.codingame.com/contribute/view/146238435972f36536302cd7da6dfc18a47099

# Goal
A reactor core is modelled as an N × N grid of integer energy values.  
To equalise the reactor, all energy values must be equal using the minimum number of operations.  

One operation consists of exactly one of the following control actions:  
* Choose a row index i and increase every cell in row i by 1
* Choose a column index j and increase every cell in column j by 1

Operations may be applied any number of times up to 100.

# Input
* Line 1: An integer N, the size of the reactor grid.
* Next N lines: Each line contains N space‑separated integers representing the energy values of the reactor core.

# Output
* A single integer — the minimum number of operations required to equalize all values across the grid, or -1 if equalisation is impossible.

# Constraints
* 1 ≤ N ≤ 100
* 0 ≤ grid values ≤ 10^9
* The result fits in a 64‑bit signed integer.
