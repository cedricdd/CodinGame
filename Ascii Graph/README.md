# Puzzle
**Ascii Graph** https://www.codingame.com/training/medium/ascii-graph

# The program
Display the given list of points in an orthonormal basis as an ASCII graph.

The X axis is represented by dash characters -.  
The Y axis is represented by vertical bar (pipe) characters |.  
The origin of the graph is represented by a plus character +.  
Every point of the given list is represented by a star character *.  
Every empty cell of the graph is represented by a dot character ..  

If one of the given points is on an axis, the star character * must be chosen over the one corresponding to the axis.

The size of the graph to display is defined by the following rules:  
The minimal coordinate on the X axis is: (Minimal X axis coordinate of any given point and/or origin) - 1  
The maximal coordinate on the X axis is: (Maximal X axis coordinate of any given point and/or origin) + 1  
The minimal coordinate on the Y axis is: (Minimal Y axis coordinate of any given point and/or origin) - 1  
The maximal coordinate on the Y axis is: (Maximal Y axis coordinate of any given point and/or origin) + 1  

# Inout
* Line 1: An integer N, the number of points on the graph
* Next N lines: Two integers x and y, separated by a space, for the coordinates of every given points.

# Output
* Strings, each one representing one ligne of the ASCII graph.

# Constraints
* 0 ≤ N ≤ 20
* -20 ≤ x ≤ 20
* -20 ≤ y ≤ 20
