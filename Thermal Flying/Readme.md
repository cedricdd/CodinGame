# Puzzle
**Thermal Flying** https://www.codingame.com/training/medium/thermal-flying---episode-1

# Goal
The air above us is not stable, there is a lot of movement and turbulences.  
Paraglider pilots use something called thermals to gain altitude.  
  
You have to simulate the flight of a pilot and give its position at a certain time t.

The simulation area is represented by a 2D grid :  
* \. means there is no thermal activity
* V pilot position (no thermal activity on this position)
* -9 to 9 thermal value

Here we consider our paraglider vertical speed is -1m/s and horizontal speed is 10m/s, it goes from left to right:  
the y step of the grid is 1 meter  
the x step of the grid is 10 meters  

If the paraglider pilot happen to be in a thermal, its altitude is increased (or decreased) by the thermal value.

If the pilot leaves the grid, you stop the simulation and print its last recorded position.

Warning ! The grid coordinates doesn't use the CG standards  
It will be in normal representation, like this:
```
2 . . .
1 . . .
0 1 2 3
```
Example: for width = 5, height = 4, t = 4
```
V . . . .
. . . 1 .
. . 2 . .
. . . . .
```
then
```
. . . . .
. V . 1 .
. . 2 . .
. . . . .
```
then
```
. . V . .
. . . 1 .
. . 2 . .
. . . . .
```
then
```
. . . V .
. . . 1 .
. . 2 . .
. . . . .
```
then
```
. . . . .
. . . 1 V
. . 2 . .
. . . . .
```
position at t is 4 2

# Input
* Line 1 : width grid width
* Line 2 : height grid height
* Line 3 : t the duration of the simulation
* Following lines: a string that give the thermal conditions

# Output
* The simulated position x y of the pilot at time t

# Constraints
* 0 ≤ t ≤ 99
