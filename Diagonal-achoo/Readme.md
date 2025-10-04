# Puzzle
**Diagonal-achoo** https://www.codingame.com/training/easy/diagonal-achoo

# Goal
In a network of top-secret underground research facilities, a group of rogue scientists are conducting unethical experiments using a synthetic, fast-mutating pathogen known as Diagonal-achoo!! This virus spreads exclusively along diagonal paths, infecting ordinary test subjects unless blocked by specially-engineered immune individuals — the H-class prototypes.

You are given g square grids representing g different simulation chambers. Each grid is of fixed size n × n, and each cell may contain:
* \. → a normal (uninfected) person
* H → a healthy person (immune)
* C → a contagious person

The infection unfolds turn-by-turn, independently in each grid. During each turn:
* Every contagious person (C) sneezes and infects diagonally adjacent normal persons (.).
* But the sneeze path is blocked if it reaches a healthy person (H).
* Infected persons (. turned to C) become contagious in the next turn and continue spreading.

Your task is to simulate the spread of infection in all grids until the infection stops (i.e., no more new infections), and print the index (0-based) along with the aftermath of the grid that ends up with the most infected people, including both initially contagious and newly infected. If a tie occurs, choose the grid with the lower index.

Example of spread of infection:
```
....       C.C.       C.C.
.C..   →   .C..   →   .C.C
..H.       C.H.       C.H.
....       ....       .C..
```

# Input
* First Line: Integer n, size of the grid (n x n)
* Second Line: Integer g, number of grids.
* Next g*n Lines: For each grid, n lines follow, each a string of length n, representing rows of that grid.

# Output
* First Line: Index of the grid with the most infected.
* Next n Lines: The grid with the most infected.

# Constraints
* 1 ≤ n ≤ 10
* 2 ≤ g ≤ 50
