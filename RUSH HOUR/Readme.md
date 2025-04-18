# Puzzle
**RUSH HOUR** https://www.codingame.com/training/medium/rush-hour

# Goal
This puzzle is inspired by a board game named Rush hour  
There is a 6x6 grid surrounded by walls, except an exit on the right of the 3rd line. 
You have to drive the red car to the exit, but there are other vehicles that obstruct the path.  

# Rules
There are vertical and horizontal vehicles. You can move any vehicle you want, but on a straight line (vehicles can't turn).   
This means that horizontal vehicles can only go LEFT and RIGHT, and vertical vehicles only UP and DOWN  

Vehicles are given by their id, top-left coordinates, length and axis (H/V).  

*Moreover:*  
* The exit is always on 3rd line (y==2), on the right.
* The ID of the red car is always 0, on the 3rd line (y==2) and the car is always 2 cells long and horizontal.
* The IDs of the other vehicles are always >0, and they are 2 or 3 cells long.
* The other vehicles can't be both horizontal and on 3rd line.

You indicate moves by the id of the vehicle, followed by the direction UP / DOWN / LEFT / RIGHT.  
You win the game when the red car is in front of the exit (x==4).  

Victory Conditions:  
* You drive the red car in front of the exit (x==4)

Loss Conditions:  
* You do not respond in time.
* You output an unrecognized id.
* You output an unrecognized direction.
* You exceed the number of turns allowed

# Initial input
* Line 1: The number n of cars

# Input per turn
* n lines: The cars represented by 4 integers id, x, y, length and one string axis

# Output per turn
* A single line containing the id and the direction of the car to move.

# Constraints
* id=0 for the red car
* 0 < id < 16 for other vehicles
* 0 <= x,y < 6
* 2 <= length <= 3
* axis='H' or 'V'
* Max response time in the 1st turn : 5 seconds
* Max response time in the other turns : 100 ms
* Max turns : 100
