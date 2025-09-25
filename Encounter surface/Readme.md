# Puzzle
**Encounter surface** https://www.codingame.com/training/hard/encounter-surface

# Goal
We consider a strategy game in which two players compete against each other. Players manipulate two armies.  
The area that each army occupies can be modeled with a single polygon.  

When the armies fight each other, they can both cover the same zone, the area where the two polygons overlap is called the "Encounter Surface."  
The goal of the puzzle is to create a tool that can show the players the area of this zone.  

# Input
* Line 1: An integer n representing the number of vertices of the polygon modeling army 1.
* Line 2: An integer m representing the number of vertices of the polygon modeling army 2.
* Next n lines: Two integers x_1 and y_1 representing the coordinates of each vertex of polygon 1.
* Next m lines: Two integers x_2 and y_2 representing the coordinates of each vertex of polygon 2.

# Output
* An integer (round up) representing the area of the "Encounter Surface."

# Constraints
* -16 ≤ x_1, y_1, x_2, y_2 ≤ 16
* 4 ≤ n, m ≤ 15
* The vertices of the polygons are not necessarily given in the order.
* The polygons representing the armies are convex polygons.
* There is at most one encounter surface.
* The sides of the polygons can be superposed that is to say that the sides of the polygons are merged together.
