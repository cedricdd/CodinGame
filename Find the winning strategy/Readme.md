# Puzzle
**Find the winning strategy** https://www.codingame.com/training/medium/find-the-winning-strategy

# Objectif
You will play a game that has a winning strategy and against a boss who knows the winning strategy. Your goal is to find this strategy in order to win.  
Hint : You can see the Sprague-Grundy theorem.

# Rules
You will play on a grid.  
On each row, each player has a token of his color that he can move only in direction of the opponent's token of this row (it can't move back) without going beyond.   
In other words, when the two tokens of a row are side by side, no more move is possible for this row.  
Each player plays in turn only one token.  
If a player can't play anymore, he loses.  
You always begin and start on a winning position.  

*Victory conditions*  
* You manage to block you opponent. 

*Loss conditions*  
* You can't play anymore.
* You do not respond in time or output an unrecognized command. 

# Input
*Initial input*  
* Line 1 : The number rows of lines.
* Line 2 : The number columns of columns.

*Input for one game turn*  
* For each game turn, in a loop for each row you have :
* The position xPlayer of your token followed by the position xBoss of your opponent's token.
* The numbering starts at 0.

# Output
* Line 1: 2 integers separated by a space row and newX corresponding to the row of the moved token and to it's new position on this row.

# Constraints
* 1 ≤ rows ≤ 40
* 3 ≤ columns ≤ 35
* 0 ≤ xPlayer < xBoss ≤ columns-1
* Response time per turn ≤ 50ms
