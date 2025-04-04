# Puzzle
**Mitosis Mayhem** https://www.codingame.com/training/medium/mitosis-mayhem

# Goal
A scientist has put you in charge of monitoring his experiment vat. You must follow their instructions and add more cells, and tell them the results when the experiment concludes.

The scientist will first tell you details about their experiment, namely max, how many cells can be in the vat at any one time, and cycles, how long the experiment will go for.  
A cycle occurs whenever you receive input. During a cycle, all cells are doubled, after which you follow the scientists instructions.

The scientist may tell you to add a cell, in the format "name initialCount power", where name is the name of the cell, initialCount is the initial number cells being added, and power is the strength of the cell.  
If the scientist tells you to put in cells that there is not enough room for, you must print OVERFLOW! and disregard all results.

The scientist might have a breakthrough during the experiment, and tell you to STOP!. This message will always come in the format STOP! 0 0, and when you receive it you should disregard all further instructions and tell the scientist the results.

When multiple cells try to grow into the same space, the conflicted territory will be split evenly (floor division) among the cells with the highest power.

When the vat is exactly full, cells with higher power will begin to take the space of cells with lower power. When this occurs, a cell will take a tenth of its desired growth from the cell with the lowest power and count that can fully support the loss.

Results should follow this format:  
EMPTY: (how many empty spaces there are remaining if > 0)  
Cell names: (how many cells of that type exist if > 0)  

Cell counts should be outputted in the same order you added them in.

# Input
* Line 1: Two space-separated integers, max and cycles
* Next cycles lines: space-separated values for the added cell consisting of the word name, and two integers, initialCount and power

# Output
* Line 1: "OVERFLOW!", a value corresponding to EMPTY, or the value of the first cell
* Next cycles lines: If not overflowed, all non-printed cells

# Constraints
* 1 ≤ max ≤ 500
* 1 ≤ cycles ≤ 10
* 0 ≤ initialCount ≤ 100
* 0 ≤ power ≤ 2
