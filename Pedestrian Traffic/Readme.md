# Puzzle
**Pedestrian Traffic** https://www.codingame.com/ide/puzzle/pedestrian-traffic

# Goal
Pedestrians are walking on a path of length n that is separated into an upper and lower lane. The upper lane is for people moving to the right and the lower lane is for people moving to the left. However, due to people walking next to their friend or being distracted by their phone, not everyone is in their correct lane.

People are differentiated by the direction in which they are moving:
* People moving toward the right: R
* People moving toward the left: L
* Open spaces on the path: o
```
              o o o o o --> Right exit
Left exit <-- o o o o o
```

Each second, everyone moves according to the following rules:
1. People will prioritize trying to move to their lane. If this is not possible or they are already in their correct lane, they will try to move forward
2. If two people both want to move forward to the same space, the one who is in their correct lane takes priority
3. If a lane switcher and forward mover want to move to the same space, the forward mover takes priority
4. People can exit from the edges of the path
5. People can move to unoccupied spaces
6. People can move to a space that was opened up due to someone else moving during the current second (for example, two people directly above and below each other can swap lanes)
7. An exception to rule 6 is that two people in the same lane cannot walk past (swap places with) each other

Your task is to determine whether the path becomes clogged so that not everyone can exit, and if everyone is able to exit, how many seconds it takes.

Example:
```
o o R L o
o L R o o

o o R R o
L o o L o

o o o R R
o o L o o

o o o o R
o L o o o

o o o o o
L o o o o

o o o o o
o o o o o
```
It takes 5 seconds for everyone to exit.

# Input
* Line 1: An integer n for the length of the path
* Lines 2 & 3: String of length n consisting of R, L, and o

# Output
* The number of seconds it takes for everyone to exit the path.
* If not everyone can exit, print "Congestion".

# Constraints
* 0 < n < 1000
