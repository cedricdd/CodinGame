# Puzzle
**A Game of Go** https://www.codingame.com/training/hard/a-game-of-go

# Goal
Go is an abstract strategy board game for two players, in which the aim is to surround more territory than the opponent.  
Given a board (where some stones are already added) and a list of moves to be executed next, check whether the moves are valid and (if they are valid) execute them.  
The initial board state in the input is always valid.

After executing all moves in the list the expected output is either NOT_VALID if at least one of the moves is invalid, or the new state of the board after all moves were executed.

**Rules of Go:**  
- Two players place stones of their color (by turns)
- If a stone is completely surrounded by stones of the other player (or by the edge of the field) this stone is beaten and is removed from the board
- If stones of the same color are placed next to each other they build a group
- If the group is completely surrounded by stones of the other player (or by the edge of the fields) 
this group is beaten and all of its stones are removed from the board
- A stone can be placed on every free field on the board except for:  
-- A position in which it would be completely surrounded by the stones of the other player (no suicidal moves allowed).  
Except this move beats some other stones which leads to it not being surrounded anymore  
-- A position that would create the same board that was there before the other player made his move (to prevent an infinite loop of killing stones) which is named KO-rule (see a test case for an example)

For a more detailed description please visit wikipedia:
https://en.wikipedia.org/wiki/Go_(game)#Rules

# Input
* Line 1: An integer S for the size of the field (the field is a square of S×S).
* Line 2: An integer M for the number of moves that are to be made on the board.
* Next S lines: A line of the board where . is an empty field, B is a field with a black stone and W is a field with a white stone on it (each line contains S characters).
* Next M lines: A move that is described by the player color, and the position (separated by a space character).
  
Example: B 0 11 means a black stone on the 1st line and the 12th column.

# Output
* If at least one of the moves in the list is not valid just print: NOT_VALID.
* If all moves from the input list are valid you have to output the board after the execution of all moves, just like in the input.
  
So a line of output could look like this:  
.BW. which means the first and the last field in this line is empty and in between there is a black and a white stone.

# Constraints
* S ≤ 19
  
S lines contain only '.', 'B' or 'W'.  
* M ≤ 15
  
A Move input starts with either B or W followed by two integers i and j that define the position of the placed stone (separated by a space character). 
The integers to define the positions can be 0 ≤ i < S (from 0 (included) to the size of the board (not included)).
