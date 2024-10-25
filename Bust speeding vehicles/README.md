# Puzzle
**Bust speeding vehicles** https://www.codingame.com/training/medium/bust-speeding-vehicles

You must detect speeding vehicles by computing their average speed between two or more consecutive cameras on a given road.  
You must print the License plate and the position of the camera where the excess speed has been detected.  

Your inputs contain all camera timestamped recordings for one or more license plates. All records are grouped by license plates and all camera distances are sorted in ascending order inside this group.  
If no excess speed is detected, your program must print OK.

# INPUT:
* Line 1: An integer L for the Speed Limit for the given road (in Kilometers per hour).
* Line 2: An integer N which represents the total number of camera readings.
* Next N Lines: 3 space separated values: The license plate recorded L, the camera distance (in Kilometers from the begining of the road) C and the timestamp of the camera capture (number of seconds since 01/01/1970) T.

# OUTPUT:
* For each speeding vehicles: print the license plate L with the detecting camera distance C, seperated by spaces, in the same order as input.
* When no vehicle is speeding: print OK

# CONSTRAINTS:
* 10 ≤ L ≤ 100
* 0 ≤ N ≤ 100
* 0 ≤ C ≤ 1000
