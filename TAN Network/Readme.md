# Puzzle
**TAN Network** https://www.codingame.com/training/hard/tan-network

# Goal
The administration of the Loire-Atlantique region, located in France, has decided to open up a large amount of public transportation information to the public. The public transport company in charge for this area is named TAN.

One part of this information is the list of TAN stops, timetables and routes. The region wants to provide TAN users with a tool which will allow them to calculate the shortest route between two stops using the TAN network. 

*Rules*  

The input data required for your program is provided in an ASCII text format:
* The stop which is the starting point of the journey
* The stop which is the final point of the journey
* The list of all the stops
* The routes between the stops
 
List of all the stops:

A series of lines representing the stops (one stop per line) and which contains the following fields:
* The unique identifier of the stop
* The full name of the stop, between quote marks"
* The description of the stop (not used)
* The latitude of the stop (in degrees)
* The longitude of the stop (in degrees)
* The identifier of the zone (not used)
* The url of the stop (not used)
* The type of stop
* The mother station (not used)

These fields are separated by a comma ,

The routes between stops:  
A list of lines representing the routes between the stops (one route per line). Each line contains two stop identifiers separated by a white space. ​

Each line represents a one-directional route running from the first identifier to the second. If two stops A and B are reciprocally accessible, then there will be two lines to represent this route:
```
A B
B A
```

Example:
```
StopArea:LAIL StopArea:GALH
StopArea:GALH StopArea:LAIL
```

DISTANCE

The distance d between two points A and B will be calculated using the following formula: https://www.codingame.com/fileservlet?id=333885671302

The program will display the list of the full names of the stops along which the shortest route passes. If there is no possible route between the starting and final stops, the program will display IMPOSSIBLE.

# Input
* Line 1: the identifier of the stop which is the starting point of the journey
* Line 2: the identifier of the stop which is the final point of the journey
* Line 3: the number N of stops in the TAN network
* N following lines: on each line a stop as described above
* Following line: the number M of routes in the TAN network
* M following lines: on each line a route as described above

# Output
* The list of the stops with their full names (one name per line) along which the shortest route passes from the start to the end of the journey (start and end included) The names must not be between quotes ".
* If it is not possible to find a route between the start and end points, the program should display IMPOSSIBLE.

# Constraints
* 0 < N < 10000
* 0 < M < 10000
