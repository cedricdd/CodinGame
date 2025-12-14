# Puzzle
**The Fall - Episode 1** https://www.codingame.com/training/medium/the-fall-episode-1

Your objective is to write a program capable of predicting the route Indy will take on his way down a tunnel. Indy is not in danger of getting trapped in this first mission.

*Rules*  
The tunnel consists of a patchwork of square rooms of different types.The rooms can be accessed and activated by computer using an ancient RS232 serial port (because Mayans aren't very technologically advanced, as is to be expected...).

There is a total of 14 room types (6 base shapes extended to 14 through rotations).

Upon entering a room, depending on the type of the room and Indy's entrance point (TOP,LEFT, or RIGHT) he will either exit the room through a specific exit point, suffer a lethal collision or lose momentum and get stuck:

Indy is perpetually drawn downwards: he cannot leave a room through the top.

At the start of the game, you are given the map of the tunnel in the form of a rectangular grid of rooms. Each room is represented by its type.

For this first mission, you will familiarize yourself with the tunnel system, the rooms have all been arranged in such a way that Indy will have a safe continuous route between his starting point (top of the temple) and the exit area (bottom of the temple).

# Each game turn
* You receive Indy's current position
* Then you specify what Indy's position will be next turn.
* Indy will then move from the current room to the next according to the shape of the current room.

*Victory Conditions*  
Indy reaches the exit
 
*Lose Conditions*  
You assert an incorrect position for Indy

# Initialization input
* Line 1: 2 space separated integers W H specifying the width and height of the grid.
* Next H lines: each line represents a line in the grid and contains W space separated integers T. T specifies the type of the room.
* Last line: 1 integer EX specifying the coordinate along the X axis of the exit (this data is not useful for this first mission, it will be useful for the second level of this puzzle).

# Input for one game turn
* Line 1: XI YI POS
  * (XI, YI) two integers to indicate Indy's current position on the grid.
  * POS a single word indicating Indy's entrance point into the current room: TOP if Indy enters from above, LEFT if Indy enters from the left and RIGHT if Indy enters from the right.

# Output for one game turn
* A single line with 2 integers: X Y representing the (X, Y) coordinates of the room in which you believe Indy will be on the next turn.

# Constraints
* 0 < W ≤ 20
* 0 < H ≤ 20
* 0 ≤ T ≤ 13
* 0 ≤ EX < W
* 0 ≤ XI, X < W
* 0 ≤ YI, Y < H
* Response time for one game ≤ 150ms
