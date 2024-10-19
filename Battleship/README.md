# Puzzle
**Battleship** https://www.codingame.com/training/medium/battleship

# Goal
You play battleship against your older sister, when an urgent desire is felt. You then ask your little brother to replace you temporarily.  
When you come back from your small business, it's up to your older sister to play.

Here is your mission, if you accept it:  
- Check that your grid is valid (your little brother could have been wrong when placing the pieces!)
- Analyze the shot of your sister to determine the rest of the game.

The rules for checking the validity of the grid are as follows:  
- Two ships can not touch each other vertically, horizontally or diagonally.
- There must be exactly 1 copy of these different ships:
    • Aircraft carrier (size 5)
    • Cruiser (size 4)
    • Counter-torpedoist (size 3)
    • Submarine (size 3)
    • Torpedoist (size 2)

The grid is always a square of 10×10 boxes, the lines being numbered from 1 to 10 and the columns being numbered from A to J.
A little example:
```
  A B C
1 . . .
2 . . .
3 . . .
```

A shot is always read beginning with the letter, for example: A5, H7, J10.

# Input
* Line 1: the shot your sister is about to play, in the form ln, where l is the letter corresponding to the column (from A to J) and n the line number (from 1 to 10).
* Next 10 lines: the state of your grid.
  
A point (.) represents a void, a plus (+) represents an intact cell occupied by one of your ships, and an underscore (_) represents a destroyed cell.

# Output
* If the grid is invalid, then the game ends: you stop there and return INVALID.
* Otherwise, analyze your sister's shot: if it falls in the water, return MISSED.
* On the other hand, if it touches one of your ships, return TOUCHE.
* If it's enough to sink it, rather return TOUCHE COULE, followed by a space and the size of the ship.
* If it makes you lose the game (all your ships are sunk), add a space followed by THEN LOSE.

# Constraints
* A ≤ l ≤ J
* 1 ≤ n ≤ 10
