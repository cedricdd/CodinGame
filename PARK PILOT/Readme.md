# Puzzle
**PARK PILOT** https://www.codingame.com/training/easy/park-pilot

# Goal
At CarAI, we produce solutions for the automotive industry. In this project, we are developing a parking pilot that can work on different brands of vehicles.

The system includes ultrasonic sensors placed at the four corners of the vehicle and a control unit to which they are connected.

Your mission is to develop an algorithm that finds all available park spaces for a vehicle which has just arrived. Below is an illustration for explanation:

```
xxxxxxxx
xxxxxxxx
xxxxxxxx park space
xxxxxxxx=============...
1------1
|--car-|  --->
1------1
xxxxxxxx=============...
xxxxxxxx park space
xxxxxxxx
xxxxxxxx
```

The system can be integrated into different vehicle models. That is why we cannot give you the length of the vehicle.   
In order for you to calculate it more accurately, a vehicle is not allowed to park near the entrance (denoted as "x" above).  

At the start, the back of the vehicle is at index 0. The sensors collect data at that moment, and every time when the vehicle has moved forward 1 unit.   
The scanning width of each sensor is 1 unit. You are now provided with all the collected data for your development of the algorithm.  

# Input
* Line 1: An integer N denoting the number of sensor data strings to read
* Next N lines: A string consisting 4 digits (0 or 1) for sensor data.

0 means no obstacle. 1 means an obstacle.  
The first line gives the data at index 0 (the point nearest the entrance), and each subsequent line gives the data 1 unit further away (index 1, 2, 3, etc).  
The sensors are located at the four corners of the vehicle, and each string gives the data of the sensors in the order of:  
Front Left - Front Right - Back Right - Back Left
```
0-------------1 Front Left
|-------------|
1-------------0 Front Right
```

# Output
* Line 1: An integer denoting the length of the vehicle
* Next lines: A string formatted as explained below for one available park space in each line. The output should be in ascending order of the index where the front of the vehicle can be parked.

String Format  
29 : Index of empty park space for the front of the vehicle  
L : L if park space is on the left side, R if park space is on the right side.  
Examples: 4R, 29L  
