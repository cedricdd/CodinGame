# Puzzle
**Belgian Train Journey** https://www.codingame.com/contribute/view/97629ee2fbdc124e12ea882955ae83e65115d

# Goal
In Belgium, the train system connects several major cities. Each city is represented by a node, and the direct train connections between the cities are represented by edges with specific travel times. Your task is to determine the shortest travel time between two given cities.

Cities and Connections:  
Brussels B  
Antwerp A  
Ghent G  
Liège L  
Namur N  
Bruges Br  
Leuven Lv  
Mons M  
Tournai T  
Charleroi C  

The connections are bidirectional. This means that if there is a connection from city A to city B with a certain travel time, there is also a connection from city B to city A with the same travel time.

The travel times between the cities are as follows:  
Brussels to Antwerp: 40 minutes  
Brussels to Ghent: 30 minutes  
Brussels to Liège: 50 minutes   
Antwerp to Namur: 70 minutes  
Ghent to Bruges: 20 minutes  
Liège to Antwerp: 70 minutes  
Namur to Mons: 30 minutes  
Bruge to Leuven: 20 minutes  
Tournai to Charleroi: 75 minutes  

# Input
Two lines containing one letter each representing the start city and the end city.
* Line 1 : city1
* Line 2 : city2

# Output
* A single integer representing the shortest travel time in minutes between the two cities. If no path exists, return -1.

# Constraints
* Cities: 11 predefined cities (B, A, G, L, N, Br, N, Lv, M, C, T).
