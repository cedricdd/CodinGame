# Puzzle
**Snakes and Ladders** https://www.codingame.com/training/medium/snakes-and-ladders

# Goal
Snakes and Ladders is a luck-based board game where players move from a starting tile to the final tile according to dice rolls. Given a Snakes and Ladders board, determine the MINIMUM number of dice rolls required to reach the final tile.

Board and Movement  
The board is a 2D grid with dimensions width × height. The player starts at the bottom-left tile (tile 1) and moves forward by traversing each row in a zigzag manner. First left to right, then right to left. Upon reaching the end of a row, the player moves up one row and continues, repeating this pattern until reaching the final tile. Tiles are numbered sequentially following these directions from 1 to width×height.  
Example in a 3x3:  
```
7 => 8 => 9
^
6 <= 5 <= 4
          ^
1 => 2 => 3
```

An n-sided die is used by a player to determine the number of tiles the player moves. Each throw the player MUST move exactly the number of tiles indicated by the die, and MUST move forward following the movement rules outlined above.

Snakes and Ladders  
Snakes and ladders are special tiles that can either hinder or aid in the journey to reach the final tile.  
* Snakes are slippery. If a player lands on a snake's head, they MUST slide down to its tail.
* Ladders are climbable. If a player lands on the bottom of a ladder, they MUST climb up to its top.  
Snakes and ladders take effect immediately after throwing a die and landing on their respective locations, but DO NOT chain together.  

# Input
* Line 1: Space-separated integers representing the width and height of the board, in the form: width height
* Line 2: Integer n representing the number of sides on the dice.
* Line 3: Space-separated integers representing the number of snakes and ladders, in the form: snake_amount ladder_amount
* Next snake_amount Lines: Space-separated integers representing the tile number of the head and tail of a snake, in the form: head tail
* Next ladder_amount Lines: Space-separated integers representing the tile number of the top and bottom of a ladder, in the form: top bottom

# Output
* Integer representing the minimum number of dice rolls required to reach the final tile.

# Constraints
* 1 ≤ width,height < 50
* 2 ≤ n < 20
* 0 ≤ snake_amount,ladder_amount < 50
* A snake's head will never be on the same tile as a ladder's bottom.
