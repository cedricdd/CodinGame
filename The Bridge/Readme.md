# Puzzle
**The Bridge** https://www.codingame.com/training/hard/the-bridge-episode-2

# Goal
There are 4 lanes on the bridge road and 1 to 4 bikes to control. There can only be one moto per lane and they are always vertically aligned.

Each game turn, you can send a single instruction to every bike. Since  the bikes operate on the same frequency, they will all synchronize on the commands you send them.

The possible commands are:
* SPEED to speed up by 1.
* SLOW to slow down by 1.
* JUMP to jump.
* WAIT to go straight on.
* UP to send all motorbikes one lane up.
* DOWN to send all motorbikes one lane down.

The starting speeds of the bikes are synced, and can be 0. After every game turn, the bikes will move a number of squares equal to their current speed across the X axis.

The UP and DOWN instructions will make the bikes move across the Y axis in addition to the movement across the X axis (Y = 0 corresponds to the highest lane).   
If a motorbike is prevented from moving up or down by the bridge's guard rails, none of the bikes will move on the Y axis that turn.

When a motorbike goes in a straight line and does not jump, if there is a hole between the current position and the next position (after the move), then the motorbike is lost forever.   
For example, if X=2 and S=3, the next position of the bike will have X=5: if there is a hole in X=3, X=4 or X=5, the bike will be destroyed.

# INPUT
* Line 1 : M the amount of motorbikes to control.
* Line 2 : V the minimum amount of motorbikes that must survive.
* Lines 3 through 6: the road ahead. Each line represents one lane of the road. A dot character . represents a safe space, a zero 0 represents a hole in the road.

# INPUT FOR ONE GAME TURN
* Line 1 : S the motorbikes' speed.
* Next M lines: X Y A two integers and a boolean seperated by spaces. 
* X, Y the coordinates of the motorbike on the road and A to indicate whether the motorbike is activated "1" or detroyed "0".

# OUTPUT
* A single line containing one of 6 keywords: SPEED SLOW JUMP WAIT UP DOWN.

# CONSTRAINTS
* The initial positions of the motorbikes are always X= 0.
* 0 ≤ S < 50
* 1 ≤ M ≤ 4
* 1 ≤ V ≤ M
* 0 ≤ X < 500
* 0 ≤ Y < 4
* Response time for one game turn ≤ 150ms
