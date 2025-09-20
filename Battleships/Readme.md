# Puzzle
**Battleships** https://www.codingame.com/contribute/view/134754c227160c01ebf872a63ea664e012d6b2

# Goal
You are given a grid representing a Battleships Solitaire puzzle. Your objective is to reconstruct the hidden fleet of ships by filling the grid according to the given clues.

A complete fleet of ships must be placed on the grid. The exact composition of the fleet (ship sizes and counts) is provided in the input and may vary between puzzles.
* Ships are straight and occupy consecutive cells either horizontally or vertically.
* Ships cannot overlap or touch each other, not even diagonally.
* Some cells may already be revealed as water or as part of a ship.
* Numbers shown next to each row and column indicate how many ship cells must appear in that line.

The goal is to place all ships so that every constraint is satisfied and the resulting configuration matches the provided clues.

This puzzle is completely solvable by applying these 5 simple rules:
* Only-spots-left rule if a row or a column requires e.g. 3 boat cells and all but 3 cells are water, the rest must be boats.
* The-rest-is-water rule: likewise, if a row or a column already has the required number of boats (including 0), the rest is water.
* Water-on-corners rule: since ships can’t touch diagonally, you can always set the corners around a boat cell to water.
* Surround-whole-boats rule: if you know where a whole boat is, you can surround it completely with water.
* Only-place-it-could-fit rule: often there’s only one spot left on the board that the largest ship could fit.

# Input
* Line 1: single integer size, the dimension of the square board.
* Line 2: size space-separated integers columnMarker, the hints above each column.
* Line 3: size space-separated integers rowMarker, the hints next to each row.
* Line 4: single integer shipsCount, the number of ships to be placed on the board.
* Line 5: shipsCount space-separated integers shipLength, the length of each ship in the fleet.
* Next size lines: each line contains size characters representing a row of the board. Each character can be:
  * \. : unresolved cell
  * ^ : bow of a vertical ship (facing north)
  * v : stern of a vertical ship (facing north)
  * < : bow of a horizontal ship (facing west)
  * \> : stern of a horizontal ship (facing west)
  * s : middle segment of a ship
  * o : single-cell ship (submarine)
  * x : water cell

# Output
* size lines of size characters: the final resolved board. Each character must be one of:
  * x : water cell.
  * o : ship cell (any part of any ship, regardless of its size or shape).

# Constraints
* 6 ≤ size ≤ 10
* 0 ≤ columnMarker, rowMarker ≤ 15
* 1 ≤ shipsCount ≤ 14
* 1 ≤ shipLength ≤ 14
* Allotted response time to output the solution is ≤ 5s
