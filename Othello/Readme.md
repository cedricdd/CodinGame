# Puzzle
**Othello** https://www.codingame.com/training/medium/othello

# Goal
You are given an Othello board and the colour and position of the next turn. You must answer if it’s legal or not.  
Othello is a two-player game. Player #1 begins and plays black (B), and player #2 plays white (W).  
B player can only put his token near a W token in order to make at least one BW+B "sandwich".   
A sandwich is defined as any number of tokens of one color consecutively in a line (either horizontally, vertically, or diagonally) which are surrounded on both sides by tokens of the opposite color. Once a sandwich is achieved, all the W tokens in this sandwich are turned into B.   
Repeat this as necessary for each valid sandwich in the eight directions (including diagonals).  
Examples (the played token in lower-case):
* --bWWWBW yields ---bBBBBW.
* BBWWWwBW yieds BBWWWwWW.
* -WWWw--- is illegal if there is no sandwich elsewhere.
* WWWbBW-- is illegal too.
  
Each player must play if possible. If not, he passes his turn.

# Input
* First 8 lines: 8 characters per line, each representing a row of the board. W is a white token, B is a black token, - is an empty cell.
* Line 9: The colour of the token, followed by a space, and then the chess-like coordinates of the next move.  
For example, a1 is the top-left corner while a8 is the bottom-left corner.

# Output
* If the move is legal, print the number of W tokens and of B tokens.
* If the cell is already filled by a token, print NOPE.
* If the token can’t make a sandwich, print NULL.
