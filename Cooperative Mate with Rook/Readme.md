# Puzzle
**Cooperative Mate with Rook** https://www.codingame.com/training/medium/cooperative-mate-with-rook

Cooperative mate is a family of Chess game puzzles where both sides cooperate towards a common goal.  
Here, we consider endgames with only black king, white king, and white rook, aiming to checkmating the black king. Your task is to provide a shortest sequence of moves leading to such mate.

# Goal
For a given state of the game, the goal is to compute a sequence of chess piece moves leading to the fastest checkmate.

# Rules
The game state is described by the player-to-move and position of each piece: white king, white rook, and black king, formatted as white d5 g7 a6.  
The goal of this puzzle is to provide a sequence of moves leading to a cooperative checkmate, according to the Chess rules. The sequence should be formatted as d5c5 a6a5 g7a7.

*Victory Conditions*  
* Given sequence of moves leads to the fastest checkmate possible in the current board position. 

*Loss Conditions*  
* Given sequence of moves does not lead to a checkmate within a turn limit.
* Given sequence of moves contains illegal move.
* Given answer is not properly formatted.
* Response time exceeds the time limit. 

*Detailed rules*  
* Given board state is always a valid Chess game position.
* You can hide showing legal moves in the settings panel ()..

*Related puzzles*  
* Adversarial variant of single rook endgames, requiring you to play as white against the black player, is available here.
* To play full version of Chess as a bot programming game you can go here.

# Input
* A single line containing space-separated strings, movingPlayer being either black or white, and whiteKing whiteRook blackKing positions in column-row format, e.g. a1.

# Output
* A single line containing a sequence of space-separated moves (each move in a1h8 format).

# Constraints
* 1 ≤ solution length ≤ 12
* Response time ≤ 20s
