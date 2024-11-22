# Puzzle
**Escaping the cat** https://www.codingame.com/training/medium/escaping-the-cat

# Goal
In this game, you control a mouse swimming in a pool trying to escape the cat. The cat is running around the pool and will try to catch you, but the cat will never go in the water.  
The goal is simply to escape from the pool without being trapped by the cat.  
If your mouse reaches the border of the pool and the distance from mouse to cat is greater or equals than 80 you win the game.  

The game is played inside a pool of radius 500 pixels where 0,0 is the center of the pool (represented by a little green dot)  

The mouse has a maximum speed MOUSE_SPEED of 10 Pixels / turn so then when providing a target destination the mouse will move towards this destination but the distance will be capped to MOUSE_SPEED.

The cat has a dynamic speed that will be provided in input.

There is no physics in this game so the mouse can change completly its direction from one turn to another.

The mouse is captured by the cat if the distance between mouse and cat is strictly less than 80 and then you lose the game.  
If you are not able to escape after 350 turns then you also lose the game.

You can display a gaming message capped to 27 Chars on the panel located in the left upper corner of the map (see details below).

*Expert Rules*  
The cat is moving using the shortest path around the pool to target the closest point where the mouse can escape.  
This is the closest intersection of straight [Center pool/mouse position] and pool edges.

# Input
*Initialization input*  
* 1 integer CatSpeed representing the speed of the cat

*Input for a game round*  
* 4 integers mouseX and mouseY representing the position of the mouse in the cartesian coordinate system where [0,0] is the center of the pool catX and catY representing the position of the cat.

# Output
* 2 integers X Y separated by spaces representing the target destination of the mouse in the cartesian coordinate system where [0,0] is the center of the pool, optionally a space + message the message to display on panel
* Example : -1000 1000 Escape the cat

# Contraintes
* X and Y should be integers
