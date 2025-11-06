# Puzzle
**Battleships** https://www.codingame.com/training/hard/battleship-solitaire

# Goal
You are given a grid representing a Battleships Solitaire puzzle. Your objective is to reconstruct the hidden fleet of ships by filling the grid according to the given clues.

A complete fleet of ships must be placed on the grid. The exact composition of the fleet (ship sizes and counts) is provided in the input and may vary between puzzles.
* Ships are straight and occupy consecutive cells either horizontally or vertically.
* Ships cannot overlap or touch each other, not even diagonally.
* Some cells may already be revealed as water or as part of a ship.
* Numbers shown next to each row and column indicate how many ship cells must appear in that line.

The goal is to place all ships so that every constraint is satisfied and the resulting configuration matches the provided clues.
![6fb72a9c8ec6d4cdf117a9e527d81423fc3bc2a1354359eeebe6f0b6b6fbe33f](https://github.com/user-attachments/assets/28f55815-935f-4268-b6ca-643a0bae4501)
 
In the example above, you can see:
* A single-cell ship (blue) occupies only one cell (o).
* All ships of size 2 or more (yellow and green) have a bow cell (^, <) and a stern cell (v, >), with any middle segments (#) filling the space between.
* A water cell (x) cannot contain any part of a ship.
* An unknown cell (.) may either contain part of a ship or water.
* The solution is invalid because 2 rows and 2 columns are not satisfied (red text).
* The solution is also invalid because the red ship is diagonally adjacent to the green ship.

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
  * \# : middle segment of a ship
  * o : single-cell ship (submarine)
  * x : water cell

# Output
* size lines of size characters: the final resolved board. Each character must be one of:
  * x : water cell.
  * o : ship cell (any part of any ship, regardless of its size or shape).

# Constraints
* 6 ≤ size ≤ 15
* 0 ≤ columnMarker, rowMarker ≤ 6
* 1 ≤ shipsCount ≤ 14
* 1 ≤ shipLength ≤ 5
* Allotted response time to output the solution is ≤ 5s
