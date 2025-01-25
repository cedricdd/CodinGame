# Puzzle
**Power of Thor - Episode 2** https://www.codingame.com/training/hard/power-of-thor-episode-2

# Goal
Thor must annihilate all the giants on the map: by striking the ground with his hammer he sends out a bolt of light which wipes out the giants which are nearby.
 
In the same way as for the previous game, you will move on a map of 40 wide by 18 high.
 
Each turn, you must either specify an action: 
* WAIT : Thor does nothing.
* STRIKE : Thor strikes.
 
Each time Thor strikes, all the giants in a square centered on Thor and of 9 spaces wide are destroyed.
 
Or you can move in the same way as in the previous game:  
* N (North)
* NE (North-East)
* E (East)
* SE (South-East)
* S (South)
* SW (South-West)
* W (West)
* NW (North-West)

On each turn during the game, once Thor has carried out an action, all the remaining giants on the map move in the direction of Thor (without ever overlapping each other).

*You lose:*  
* if a giant moves on top of Thor
* if there are giants remaining on the map and Thor doesn't have any hammer strikes left.
* if Thor moves off the map
* if the program exceeds the maximum number of authorized turns, which is fixed at 200

# Input
The program must first read the initialization data from standard input. Then, within an infinite loop, read the data from the standard input related to Thor's current state and provide to the standard output Thor's movement instructions.

*Initialization input*  
* Line 1: 2 integers TX TY. (TX, TY) indicates Thor's starting position.

*Input for one game turn:*  
* Line 1: 2 integers H N:
 * H indicates the remaining number of hammer strikes.
 * N indicates the number of giants which are still present on the map.
* N next lines: the positions X Y of the giants on the map.

# Output
* A single line, which indicates the movement or action to be carried out: WAIT STRIKE N NE E SE S SW W or NW

# Constraints
* 0 ≤ TX < 40
* 0 ≤ TY < 18
* 0 < H ≤ 100
* 0 < N ≤ 100
* 0 ≤ X < 40
* 0 ≤ Y < 18
* Response time for each turn ≤ 100ms
