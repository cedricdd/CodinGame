# Puzzle
**Can you save the forest - Episode 1** https://www.codingame.com/training/medium/can-you-save-the-forest---episode-1

# Goal
In this game you have to extinguish the fire while saving as many squares in the forest as possible.

You operate on a 10x10 square map.  
At each turn, your program receives the map of the forest and the state of each square.  
Based on this data, your program must determine which forest square to send water to in order to put out the fire.  
Unfortunately, under certain circumstances, as described below, fires spread to neighbouring squares.  
To win you must put out all the fires, while limiting the number of squares burned to a maximum given to you in the variable maxBurnedForest.  

*The map*  
Each of the 10 lines of the map is given to you by a string. Each character represents a cell of the map.  
- . represents an empty square with no forest. It cannot burn.
- ^ represents a forest square.
- \* represents a burned forest square. It can no longer catch fire.
- 1, 2 or 3 represents a forest square on fire. The value corresponds to the development level of the fire.


Fire on a square can have 3 levels of development and, unless fought, evolves as such:
* Fires grow by one level per turn.
* Except for level 3 fires which, on the next turn, turn into burned forest squares and spread the fire to their 4 neighbouring squares (N/S/E/W) if:
  * The neighbouring square is a forest square, not burned.
  * There is not already a fire on this square.
* The fire on these neighbouring squares starts at level 1. 

*Fighting fire*  
Once per turn you can extinguish the fire in a square by spraying it with water.  
The fire in this square is extinguished immediately and does not spread to neighbouring squares.  
To determine the box for which you want to fight the fire, you simply write its x and y coordinates (or column and row) on the standard output.  

*Sequence of actions*  
In each turn, the game follows the following actions, in this order  
* Extinguish the fire on the square determined by your program.
* Evolution of the remaining fires (1>>2, 2>>3, 3>>burned)
* Spread of fire around the squares that have just been burned

*losing conditions*  
* You do not send the coordinates of a game square within the time limit.
* The number of squares burned exceeds the maximum indicated in maxBurnedForest.
 
*Victory conditions*  
* You win when there are no active fires left on the map and the number of burned forest squares remains below maxBurnedForest.

# Input
*Initialization input*  
* 1 integer maxBurnedForest representing the maximum number of forest squares burned that you are allowed.

*Input for a game round*  
* 10 rows row representing the map of the forest and its active fires

# Output
* Two integers X and Y to designate the square on which to put out the fire.
