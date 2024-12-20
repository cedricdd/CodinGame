# Puzzle
**Custom Game of Life** https://www.codingame.com/training/medium/custom-game-of-life

# Goal
You probably know the game of life, if you don't: https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life  
It is a cellular automaton created by John Conway in 1970. An infinite grid made of dead and living cells that changes each turn following specific rules:  
* A living cell will survive only if it has 2 or 3 neighbours (<2: isolation death, >3: overpopulation death).
* If a dead cell has exactly 3 neighbours, it comes back to life, else it stays dead.
* Neighbours is the number of neighbours with Moore neighbourhood (8 cells).

You will be given new rules and will have to adapt the evolution of the grid to these:  
* The first line is the condition of surviving of a living cell, and the second line is the birth condition of a dead cell.
* The index within the line is the number of neighbours, 0 to 8. Living is represented by 1, dead by 0.
* Your goal is to output the grid given in input after n turns and with specific given rules.

Example: Classic rules  
001100000 A living cell survives if it has 2 or 3 neighbours, and dies if 0,1 or 4+.  
000100000 A dead cell is back to life if it has 3 neighbours, and stays dead if any other number.  

A cell outside the grid will always be considered as dead.

# Input
* First line: h & w, height and width of the grid, n the number of turns you have to simulate before output.
* Second line: 9 not space separated binary integers, the condition of surviving of a living cell (0: dies, 1: stays alive).
* Third line: 9 not space separated binary integers, the condition of birth of a dead cell (0: stays dead, 1: birth).
* Next h lines: w-length string for cells (.: dead, O: alive).

# Output
* h lines of w-length strings for cells after n turns (.: dead, O: alive).

# Constraints
* 0 < w, h, n ≤ 20
