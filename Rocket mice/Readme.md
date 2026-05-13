# Puzzle
**Rocket mice** https://www.codingame.com/training/hard/rocket-mice

# Goal
A colony of peaceable, space-faring mice has been invaded by cats. You must get the mice to your rocket so they can evade the evil cats' claws.

Calculate the final score for all players in the game, based on the moves made.

*Scoring*  
Each player has a rocket on a grid of squares. A player scores 1 point for each mouse that enters his rocket, and -10 points for each cat that enters his rocket. Animals can enter a rocket from any orthogonally adjacent square.

A player's score can never go below zero.

*Animal generation*  
Each board has one or more doors on the edges of the grid. Animals enter through these doors and always move directly away from the door they entered through, in a direction perpendicular to the wall where the door is located. So, for example, if a mouse enters through a door on the northern edge of the grid, it will move south. Doors are never in the corners of the grid.  
Animals always go straight until they leave the board (rocket, pit, or eaten) or are redirected (wall or arrow).  
Each door produces 1 animal every turn. Every 10th animal to enter through each door is a cat. The other 9 animals produced are mice.

*Walls and pits*  
If an animal hits a wall, it will turn 90 degrees counter-clockwise. Animals never exit through doors. They only enter through them. Otherwise, a door behaves like a wall.  
The four squares in the corners of the grid are pits. If a mouse or a cat moves to one of these squares, they fall to their doom.  

*Eaten by cats*  
Multiple mice can coexist on the same square, and multiple cats can coexist on the same square, but mice and cats don't mix. A mouse on the same square as a cat is eaten.  
If a mouse and cat switch positions, i.e. mouse from (1,2) to (1,3) and cat from (1,3) to (1,2), the mouse is eaten in passing.

*Arrows*  
Each turn, one player places an arrow onto a square of the grid. Arrows point in any of four directions: N, E, S, or W. The players take turns placing arrows. Player 1 places on the first turn, then player 2 on the next turn, etc. Arrows cannot be placed onto another arrow, a rocket, or a pit.  
Each player can have a maximum of 3 arrows on the grid at a time. Once a player places his 4th arrow, then the first arrow he placed is removed. When his 5th is placed, his 2nd is removed, and so on.  
When an animal moves to a square with an arrow, it turns to face the direction indicated by the arrow.  

*Order of a turn*  
1) An animal is produced behind each door, just off the grid, ready to enter the board.
2) All animals move forward one square, simultaneously, in the direction they are facing.
3) Mice score.
4) Cats score.
5) Mice are eaten.
6) All animals on an arrow or facing a wall are redirected.
7) The next player to play places an arrow.

After the final arrow is placed on the last turn, steps 1-4 are executed one more time to determine the score.

# Input
* Line 1: Two space-separated integers indicating the width and height of the grid
* Line 2: An integer indicating the number of players in the game
* Line 3: An integer indicating the number of doors on the grid
* Line 4: An integer indicating the number of turns to be played
* Next players lines: Two space-separated integers (rX and rY) indicating the coordinates of each player's rocket
* Next doors lines: An integer indicating the x or y coordinate of the door, followed by the wall that the door is on, either N, E, S, or W
* Next turns lines: Two space-separated integers (tX and tY) indicating the coordinates where an arrow is placed, followed by a direction, either N, E, S, or W.

# Output
* players lines: One line per player, indicating that player's score for the game

# Constraints
* 5 ≤ width = height ≤ 25
* 2 ≤ players ≤ 4
* 1 ≤ doors ≤ 16
* 1 ≤ turns ≤ 100
* 0 ≤ rX, tX ≤ width - 1
* 0 ≤ rY, tY ≤ height - 1
* (0, 0) is the north-west corner.
* (width-1, 0) is the north-east corner.
